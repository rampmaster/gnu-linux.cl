<?php

/**
 * SowerPHP: Minimalist Framework for PHP
 * Copyright (C) SowerPHP (http://sowerphp.org)
 * 
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 * 
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 * 
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

// namespace del modelo
namespace website;

/**
 * Clase abstracta para mapear la tabla noticia de la base de datos
 * Comentario de la tabla: 
 * Esta clase permite trabajar sobre un registro de la tabla noticia
 * @author SowerPHP Code Generator
 * @version 2014-04-05 22:18:13
 */
abstract class Model_Base_Noticia extends \Model_App
{

    // Atributos de la clase (columnas en la base de datos)
    public $id; ///< int(11)(10) NOT NULL DEFAULT '' AUTO PK 
    public $nombre; ///< varchar(255)(255) NOT NULL DEFAULT '' 
    public $contenido; ///< text(65535) NOT NULL DEFAULT '' 

    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'id' => array(
            'name'      => 'Id',
            'comment'   => '',
            'type'      => 'int(11)',
            'length'    => 10,
            'null'      => false,
            'default'   => "",
            'auto'      => true,
            'pk'        => true,
            'fk'        => null
        ),
        'nombre' => array(
            'name'      => 'Nombre',
            'comment'   => '',
            'type'      => 'varchar(255)',
            'length'    => 255,
            'null'      => false,
            'default'   => "",
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),
        'contenido' => array(
            'name'      => 'Contenido',
            'comment'   => '',
            'type'      => 'text',
            'length'    => 65535,
            'null'      => false,
            'default'   => "",
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),

    );

    public static $fkModule; ///< Modelos utilizados (se asigna en Noticia)
    
    /**
     * Constructor de la clase abstracta
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function __construct ($id = null)
    {
        // ejecutar constructor de la clase padre
        parent::__construct();
        // setear todo a nulo
        $this->clear();
        // setear atributos del objeto con lo que se haya pasado al
        // constructor como parámetros
        if (func_num_args()>0) {
            $firstArg = func_get_arg(0);
            if (is_array($firstArg)) {
                $this->set($firstArg);
            } else {
                $this->id = $id;
            }
        }
        // obtener otros atributos del objeto
        $this->get();
    }

    /**
     * Setea a null los atributos de la clase (los que sean columnas de
     * la tabla)
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    protected function clear ()
    {
        $this->id = null;
        $this->nombre = null;
        $this->contenido = null;
    }

    /**
     * Método para obtener los atributos del objeto, esto es cada una
     * de las columnas que representan al objeto en la base de datos
     */
    public function get ()
    {
        // solo se recuperan los datos si se seteo la PK
        if (!empty($this->id)) {
            // obtener columnas desde la base de datos
            $datos = $this->db->getRow("
                SELECT *
                FROM noticia
                WHERE id = '".$this->db->sanitize($this->id)."'
            ");
            // si se encontraron datos asignar columnas a los atributos
            // del objeto
            if (count($datos)) {
                foreach ($datos as $key => &$value) {
                    $this->{$key} = $value;
                }
            }
            // si no se encontraron limpiar atributos
            else {
                $this->clear();
            }
            // eliminar variable datos
            unset($datos);
        }
    }
    
    /**
     * Método para determinar si el objeto existe en la base de datos
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function exists ()
    {
        // solo se ejecuta si la PK existe seteada
        if (!empty($this->id)) {
            return (boolean) $this->db->getValue("
                SELECT COUNT(*) FROM noticia
                WHERE id = '".$this->db->sanitize($this->id)."'
            ");
        } else {
            return false;
        }
    }

    /**
     * Método para borrar el objeto de la base de datos
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function delete ()
    {
        $this->db->transaction();
        if (!$this->beforeDelete()) { $this->db->rollback(); return false; }
        $this->db->query("
            DELETE FROM noticia
            WHERE id = '".$this->db->sanitize($this->id)."'
        ");
        if (!$this->afterDelete()) { $this->db->rollback(); return false; }
        $this->db->commit();
        return true;
    }

    /**
     * Método para insertar el objeto en la base de datos
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    protected function insert ()
    {
        $this->db->transaction();
        if (!$this->beforeInsert()) { $this->db->rollback(); return false; }
        $this->db->query("
            INSERT INTO noticia (
                nombre,
                contenido
            ) VALUES (
                ".(!empty($this->nombre) || $this->nombre=='0' ? "'".$this->db->sanitize($this->nombre)."'" : 'NULL').",
                ".(!empty($this->contenido) || $this->contenido=='0' ? "'".$this->db->sanitize($this->contenido)."'" : 'NULL')."
            )
        ");
        if (!$this->afterInsert()) { $this->db->rollback(); return false; }
        $this->db->commit();
        return true;
    }

    /**
     * Método para actualizar el objeto en la base de datos
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    protected function update ()
    {
        $this->db->transaction();
        if (!$this->beforeUpdate()) { $this->db->rollback(); return false; }
        $this->db->query("
            UPDATE noticia SET
                nombre = ".(!empty($this->nombre) || $this->nombre=='0' ? "'".$this->db->sanitize($this->nombre)."'" : 'NULL').",
                contenido = ".(!empty($this->contenido) || $this->contenido=='0' ? "'".$this->db->sanitize($this->contenido)."'" : 'NULL')."
            WHERE
                id = '".$this->db->sanitize($this->id)."'
        ");
        if (!$this->afterUpdate()) { $this->db->rollback(); return false; }
        $this->db->commit();
        return true;
    }



    /**
     * Método que guarda un archivo en la base de datos
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function saveFile ($name, $file)
    {
        $this->db->transaction();
        if (!$this->beforeUpdate()) { $this->db->rollback(); return false; }
        if (get_class($this->db)=='PostgreSQL')
            $file['data'] = pg_escape_bytea($file['data']);
        else
            $file['data'] = $this->db->sanitize($file['data']);
        $name = $this->db->sanitize($name);
        $this->db->query("
            UPDATE noticia
            SET
                ${name}_data = '".$file['data']."'
                , ${name}_name = '".$this->db->sanitize($file['name'])."'
                , ${name}_type = '".$this->db->sanitize($file['type'])."'
                , ${name}_size = ".(integer)$this->db->sanitize($file['size'])."
            WHERE
                id = '".$this->db->sanitize($this->id)."'
        ");
        if (!$this->afterUpdate()) { $this->db->rollback(); return false; }
        $this->db->commit();
        return true;
    }

}
