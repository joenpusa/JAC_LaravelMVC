<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Str;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Junta;
use App\Models\Asociacion;
use ZipArchive;
use App\Mail\JuntaArchivosMail;
use App\Mail\AsociacionArchivosMail;
use Illuminate\Support\Facades\Mail;


class DocumentoController extends Controller
{

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nomanexo' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,docx|max:5120',
            'documentable_type' => 'required|string|in:junta,asociacion',
            'documentable_id' => 'required|integer',
        ], [
            'archivo.required' => 'El archivo es requerido.',
            'archivo.max' => 'El archivo debe ser menor a 5MB.',
            'archivo.mimes' => 'El archivo debe ser un archivo PDF o un archivo de Word.',
            'documentable_type.required' => 'El tipo de documento es requerido.',
        ]);

        // Verificar si la relación existe (junta o asociacion)
        if ($request->documentable_type === 'junta') {
            $relatedModel = Junta::findOrFail($request->documentable_id);
            $folder = 'documentos_juntas/';
        } elseif ($request->documentable_type === 'asociacion') {
            $relatedModel = Asociacion::findOrFail($request->documentable_id);
            $folder = 'documentos_asociaciones/';
        }

        // Procesar el archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $folder . $request->documentable_id;
            $rutaArchivo = $archivo->storeAs($rutaCarpeta, $nombreArchivo, 'public');
        }

        // Crear el documento
        $relatedModel->documentos()->create([
            'nomanexo' => $request->nomanexo,
            'keyanexo' => $rutaArchivo,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Documento cargado correctamente');
    }


    public function show($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return redirect()->back()->with('error', 'El documento no existe.');
        }

        if (Storage::disk('public')->exists($documento->keyanexo)) {
            $url = Storage::url($documento->keyanexo);
            return redirect($url);
        } else {
            return redirect()->back()->with('error', 'El archivo no se encuentra en el sistema.');
        }
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return redirect()->back()->with('error', 'El documento no existe.');
        }

        if (Storage::disk('public')->exists($documento->keyanexo)) {
            $deleted = Storage::disk('public')->delete($documento->keyanexo);
            if (!$deleted) {
                return redirect()->back()->with('error', 'No se pudo eliminar el archivo. Valide permisos de escritura.');
            }
        } else {
            return redirect()->back()->with('error', 'Archivo no encontrado ' . $documento->keyanexo);
        }

        $documento->delete();

        return redirect()->back()->with('success', 'Documento eliminado correctamente');
    }

    // public function descargarArchivos($junta_id, $num_documento)
    // {
    //     $tempDir = storage_path('temp');
    //     if (!is_dir($tempDir)) {
    //         mkdir($tempDir, 0777, true);
    //     }
    //     putenv("TMPDIR=$tempDir");

    //     // Validar que el número de documento pertenece al presidente de la junta
    //     $junta = Junta::with('presidente')->find($junta_id);

    //     if (!$junta || $junta->presidente->num_documento !== $num_documento) {
    //         return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la junta seleccionada.']);
    //     }

    //     // Buscar documentos asociados a la junta
    //     $documentos = Documento::where('documentable_type', Junta::class)
    //         ->where('documentable_id', $junta_id)
    //         ->get();

    //     if ($documentos->isEmpty()) {
    //         return redirect()->back()->withErrors(['error' => 'No hay archivos adjuntos para esta junta.']);
    //     }

    //     // Crear el nombre del archivo ZIP
    //     $zip = new ZipArchive();
    //     $zipFileName = "archivos_junta_{$junta_id}.zip";
    //     $zipPath = $tempDir . '/' . $zipFileName;
    //     if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    //         foreach ($documentos as $documento) {
    //             $filePath = storage_path('app/public/' . $documento->keyanexo);
    //             if (file_exists($filePath)) {
    //                 $zip->addFile($filePath, basename($filePath));
    //             } else {
    //                 \Log::error("Archivo no encontrado: $filePath");
    //             }
    //         }
    //         $zip->close();
    //     } else {
    //         \Log::error("No se pudo abrir el archivo ZIP: $zipPath");
    //         return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
    //     }

    //     // Descargar el archivo ZIP
    //     return response()->download($zipPath)->deleteFileAfterSend(true);
    // }


    public function descargarArchivos($junta_id, $num_documento)
    {
        $tempDir = storage_path('temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        putenv("TMPDIR=$tempDir");

        $junta = Junta::with('presidente')->find($junta_id);

        if (!$junta || $junta->presidente->num_documento !== $num_documento) {
            return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la junta seleccionada.']);
        }

        $documentos = Documento::where('documentable_type', Junta::class)
            ->where('documentable_id', $junta_id)
            ->get();

        if ($documentos->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'No hay archivos adjuntos para esta junta.']);
        }

        $zip = new \ZipArchive();
        $zipFileName = "archivos_junta_{$junta_id}.zip";
        $zipPath = $tempDir . '/' . $zipFileName;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($documentos as $documento) {
                $filePath = storage_path('app/public/' . $documento->keyanexo);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                } else {
                    \Log::error("Archivo no encontrado: $filePath");
                }
            }
            $zip->close();
        } else {
            \Log::error("No se pudo abrir el archivo ZIP: $zipPath");
            return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
        }

        // Enviar correo con el ZIP adjunto
        Mail::to($junta->presidente->email)->send(new JuntaArchivosMail($junta, $zipPath));

        // Eliminar archivo ZIP después de enviar
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        return redirect()->back()->with('success', 'Archivos enviados correctamente al correo.');
    }


    // public function descargarArchivosAso($asociacion_id, $num_documentoAso)
    // {
    //     $tempDir = storage_path('temp');
    //     if (!is_dir($tempDir)) {
    //         mkdir($tempDir, 0777, true);
    //     }
    //     putenv("TMPDIR=$tempDir");

    //     // Validar que el número de documento pertenece al presidente de la asociacion
    //     $asociacion = ASociacion::with('presidente')->find($asociacion_id);

    //     if (!$asociacion || $asociacion->presidente->num_documento !== $num_documentoAso) {
    //         return redirect()->back()->withErrors(['num_documentoAso' => 'El número de documento no coincide con el presidente de la asociación seleccionada.']);
    //     }

    //     // Buscar documentos asociados a la asociacion
    //     $documentos = Documento::where('documentable_type', Asociacion::class)
    //         ->where('documentable_id', $asociacion_id)
    //         ->get();

    //     if ($documentos->isEmpty()) {
    //         return redirect()->back()->withErrors(['error' => 'No hay archivos adjuntos para esta asociación.']);
    //     }

    //     // Crear el nombre del archivo ZIP
    //     $zip = new ZipArchive();
    //     $zipFileName = "archivos_asociacion_{$asociacion_id}.zip";
    //     $zipPath = $tempDir . '/' . $zipFileName;
    //     if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    //         foreach ($documentos as $documento) {
    //             $filePath = storage_path('app/public/' . $documento->keyanexo);
    //             if (file_exists($filePath)) {
    //                 $zip->addFile($filePath, basename($filePath));
    //             } else {
    //                 \Log::error("Archivo no encontrado: $filePath");
    //             }
    //         }
    //         $zip->close();
    //     } else {
    //         \Log::error("No se pudo abrir el archivo ZIP: $zipPath");
    //         return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la asociación seleccionada.']);
    //     }

    //     // Descargar el archivo ZIP
    //     return response()->download($zipPath)->deleteFileAfterSend(true);
    // }

    public function descargarArchivosAso($asociacion_id, $num_documentoAso)
    {
        $tempDir = storage_path('temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        putenv("TMPDIR=$tempDir");

        $asociacion = Asociacion::with('presidente')->find($asociacion_id);

        if (!$asociacion || $asociacion->presidente->num_documento !== $num_documentoAso) {
            return redirect()->back()->withErrors(['num_documento' => 'El número de documento no coincide con el presidente de la asociacion seleccionada.']);
        }

        $documentos = Documento::where('documentable_type', Asociacion::class)
            ->where('documentable_id', $asociacion_id)
            ->get();

        if ($documentos->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'No hay archivos adjuntos para esta asociacion.']);
        }

        $zip = new \ZipArchive();
        $zipFileName = "archivos_asociacion_{$asociacion_id}.zip";
        $zipPath = $tempDir . '/' . $zipFileName;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($documentos as $documento) {
                $filePath = storage_path('app/public/' . $documento->keyanexo);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                } else {
                    \Log::error("Archivo no encontrado: $filePath");
                }
            }
            $zip->close();
        } else {
            \Log::error("No se pudo abrir el archivo ZIP: $zipPath");
            return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
        }

        // Enviar correo con el ZIP adjunto
        Mail::to($asociacion->presidente->email)->send(new AsociacionArchivosMail($asociacion, $zipPath));

        // Eliminar archivo ZIP después de enviar
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        return redirect()->back()->with('success', 'Archivos enviados correctamente al correo.');
    }

}
