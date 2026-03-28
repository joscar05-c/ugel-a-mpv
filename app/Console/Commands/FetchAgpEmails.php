<?php

namespace App\Console\Commands;

use App\Models\CorreoEntrante;
use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

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
        ini_set('memory_limit', '1024M');
        $this->info('Iniciando la conexión con el servidor IMAP...');
        try {
            $client = Client::account('default');
            $client->connect();

            //abre la bandeja de entrada
            $folder = $client->getFolder('INBOX');

            //Buscar todos los correos que no han sido leidos con unseen
            $messages = $folder->query()
                ->unseen()
                ->since(\Carbon\Carbon::now()->subDays(3))
                ->limit(10)
                ->get();

            $this->info("Se encontraron " . $messages->count() . " correos nuevos en este lote.");

            foreach ($messages as $message) {
                //preparamos los datos básicos
                $messageId = $message->getMessageId();
                $asunto = $message->getSubject();
                $cuerpo = $message->getTextBody() ?? $message->getHTMLBody();

                //extraer el remitente, toma el primero si son varios
                $remitentes = $message->getFrom();

                if (!empty($remitentes)) {
                    $remitente = $remitentes[0];

                    // Si la propiedad 'mail' existe la usa, de lo contrario arma el correo uniendo el buzón y el host
                    $remitenteEmail = isset($remitente->mail)
                        ? $remitente->mail
                        : ($remitente->mailbox . '@' . $remitente->host);

                    // Aseguramos que el nombre no tire error si viene vacío
                    $remitenteNombre = isset($remitente->personal) ? $remitente->personal : 'Desconocido';
                } else {
                    $remitenteEmail = 'desconocido@ugel.gob.pe';
                    $remitenteNombre = 'Remitente Oculto';
                }
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
                    'fecha_recepcion_correo' => \Carbon\Carbon::parse($message->getDate()[0]),
                ]);

                //manejamos los adjuntos si es que hay
                $rutasGuardadas = [];
                if ($tieneAdjuntos) {
                    $attachments = $message->getAttachments();

                    foreach ($attachments as $attachment) {
                        //generamos un nombre único
                        $filename = time() . '_' . $attachment->getName();
                        $ruta = 'adjuntos_correos/' . $filename;
                        //guardamos fisicamente en storage
                        Storage::disk('public')->put('adjuntos_correos/' . $filename, $attachment->getContent());
                        // NOTA: Aquí podrías crear un registro temporal en una tabla si deseas
                        // enlazar el archivo al correo antes de convertirlo en expediente.
                        $rutasGuardadas[] = $ruta;
                    }
                    //actualizamos el registro en la BD con lss rutas
                    $correoBD->update(['rutas_adjuntos' => $rutasGuardadas]);
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
