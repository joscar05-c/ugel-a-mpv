<?php

namespace App\Console\Commands;

use App\Models\CorreoEntrante;
use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Storage;

class FetchAgpEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imap:fetch-agp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lee la bandeja de entrada del correo AGP y guarda los mensajes en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando la conexión con el servidor IMAP...');
        try {
            $client = Client::account('default');
            $client->connect();

            //abre la bandeja de entrada
            $folder = $client->getFolder('INBOX');

            //Buscar todos los correos que no han sido leidos con unseen
            $messages = $folder->query()->unseen()->get();

            $this->info("Se encontraron " . $messages->count() . " correos nuevos.");

            foreach($messages as $message){
                //preparamos los datos básicos
                $messageId = $message->getMessageId();
                $asunto = $message->getSubject();
                $cuerpo = $message->getTextBody() ?? $message->getHTMLBody();

                //extraer el remitente, toma el primero si son varios
                $remitente = $message->getFrom()[0];
                $remitenteEmail = $remitente->email;
                $remitenteNombre = $remitente->personal ?? 'Desconocido';

                //por las dudas verificamos si el correo ya existe en la BD
                if (CorreoEntrante::where('message_id', $messageId)->exists()) {
                    continue;
                }

                $tieneAdjuntos = $message->hasAttachments();

                //guardamos en la BD
                $correoBD = CorreoEntrante::create([
                    'message_id' => $messageId,
                    'remitente_email' => $remitenteEmail,
                    'remitente_nombre' => $remitenteNombre,
                    'asunto' => $asunto,
                    'cuerpo_texto' => $cuerpo,
                    'tiene_adjuntos' => $tieneAdjuntos,
                    'procesado' => false,
                    'fecha_recepcion_correo' => $message->getDate()->toCarbon(),
                ]);

                //manejamos los adjuntos si es que hay
                if ($tieneAdjuntos) {
                    $attachments = $message->getAttachments();

                    foreach ($attachments as $attachment) {
                        //generamos un nombre único
                        $filename = time() . '_' . $attachment->getName();
                        //guardamos fisicamente en storage
                        Storage::disk('public')->put('adjuntos_correos/' . $filename, $attachment->getContent());
                        // NOTA: Aquí podrías crear un registro temporal en una tabla si deseas
                        // enlazar el archivo al correo antes de convertirlo en expediente.
                    }
                }
                //marcar el correo como leído
                $message->setFlag(['Seen']);

                $this->info("Procesado: {$asunto} de {$remitenteEmail}");
            }
            $this->info('Proceso IMAP finalizado correctamente.');

        } catch (\Exception $e) {
            $this->error('Error de conexión IMAP: ' . $e->getMessage());
        }
    }
}
