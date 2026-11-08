<?php

require_once __DIR__ . "/../../../exceptions/ArchivoException.php";

class ExportadorCSV
{
    public function exportar(array $libros): string
    {
        $directorio = dirname(__DIR__ ,3). "/exports";
        if (!is_dir($directorio) && !mkdir($directorio, 0750, true) && !is_dir($directorio)) {
            throw new ArchivoException("No se pudo preparar la exportación.");
        }

        $ruta = tempnam($directorio, "biblioteca_");
        if ($ruta === false) {
            throw new ArchivoException("No se pudo crear el archivo de exportación.");
        }

        $archivo = fopen($ruta, "wb");
        if ($archivo === false) {
            unlink($ruta);
            throw new ArchivoException("No se pudo abrir el archivo de exportación.");
        }

        $escrituraCorrecta = fputcsv($archivo, [
            "titulo",
            "genero",
            "autor",
            "ano_publicacion",
            "editorial"
        ]);
        if ($escrituraCorrecta === false) {
            fclose($archivo);
            unlink($ruta);
            throw new ArchivoException("No se pudo escribir el encabezado del CSV.");
        }

        foreach ($libros as $libro) {
            $escrituraCorrecta = fputcsv($archivo, [
                $libro["titulo"],
                $libro["genero"],
                $libro["autor"],
                $libro["ano_publicacion"],
                $libro["editorial"]
            ]);
            if ($escrituraCorrecta === false) {
                fclose($archivo);
                unlink($ruta);
                throw new ArchivoException("No se pudieron escribir los datos del CSV.");
            }
        }
        if (!fclose($archivo)) {
            unlink($ruta);
            throw new ArchivoException("No se pudo finalizar el archivo CSV.");
        }
        return $ruta;
    }
}
