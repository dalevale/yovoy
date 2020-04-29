<?php
//namespace es\ucm\fdi\aw;
require_once __DIR__.'/Form.php';

/**
 * Clase base para la gestión de formularios.
 *
 * Además de la gestión básica de los formularios.
 */
abstract class FormWithFile extends Form
{

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string[] $datos (opcional) Array con los valores por defecto de los campos del formulario.
     *
     * @return string HTML asociado al formulario.
     */
    private function generateForm($errors = array(), &$data = array())
    {

        $html= $this->generateErrorList($errors);

        $html .= '<form enctype="multipart/form-data" method="POST" class="tarjeta-gris" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generateFormFields($data);
        $html .= '</form>';
        return $html;
    }

}
