<?php
//namespace es\ucm\fdi\aw;

/**
 * Clase base para la gestión de formularios.
 *
 * Además de la gestión básica de los formularios.
 */
abstract class Form {

    /**
     * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
     * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     */
    private $formId;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
     * envío del formulario.
     */
    protected $action;

    /**
     * Crea un nuevo formulario.
     *
     * Posibles opciones:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Opción</th>
     *       <th>Valor por defecto</th>
     *       <th>Descripción</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>action</td>
     *       <td><code>$_SERVER['PHP_SELF']</code></td>       
     *       <td>URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará
                 el envío del formulario.</td>
     *     </tr>
     *   </tbody>
     * </table>

     * @param string $formId    Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al
     *                          formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     *
     * @param array $options (ver más arriba).
     */
    public function __construct($formId, $options = array() )
    {
        $this->formId = $formId;

        $defaultOptions = array( 'action' => null, );
        $options = array_merge($defaultOptions, $options);

        $this->action   = $options['action'];
        
        if ( !$this->action ) {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
  
    /**
     * Se encarga de orquestar todo el proceso de gestión de un formulario.
     */
    public function manage()
    {   
        
        
        if ( ! $this->formSent($_POST) ) {
            return $this->generateForm();
        } 
        else {
            $result = $this->processForm($_POST);
            if ( is_array($result) ) {
                return $this->generateForm($result, $_POST);
            } else {
                if($this->formId == 'registerForm')
                    $str = 'Se ha creado la cuenta correctamente. Inicia sesión con la nueva cuenta.';
                else if($this->formId == 'newEventForm')
                    $str = 'Se ha creado el evento correctamente.';
                else if($this->formId == 'editEventForm')
                    $str = 'Se ha editado el evento correctamente.';
                else if($this->formId == 'editProfileForm')
                    $str = 'Se ha editado el perfil correctamente.';
                else if($this->formId == 'reportForm')
                    $str = 'Se ha mandado el report al admin correctamente.';
                else if($this->formId == 'reportForm')
                    $str = 'Se ha hecho el cambio correctamente.';
                if(isset($str)){
                    echo'<script type="text/javascript">
		            alert("'.$str.'");
		            window.location.href = "'.$result.'";
                    </script>';
				}
                else
                    header('Location: '.$result);
                exit();
            }
        }  
    }

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generateFormFields($initialData)
    {
        return '';
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
     * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
     */
    protected function processForm($data)
    {
        return array();
    }
  
    /**
     * Función que verifica si el usuario ha enviado el formulario.
     * Comprueba si existe el parámetro <code>$formId</code> en <code>$params</code>.
     *
     * @param string[] $params Array que contiene los datos recibidos en el envío formulario.
     *
     * @return boolean Devuelve <code>true</code> si <code>$formId</code> existe como clave en <code>$params</code>
     */
    private function formSent(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

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
        $html .= '<ul id="printError" style="display:none;"></ul>';
        $html .= '<form enctype="multipart/form-data" method="POST" class="tarjeta-gris" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generateFormFields($data);
        $html .= '</form>';
        $html .= '<script type="text/javascript" src="includes/js/validatingFunctions.js"></script>';
        return $html;
    }

    /**
     * Genera la lista de mensajes de error a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    private function generateErrorList($errors)
    {
        $html='';
        $numErrors = count($errors);
        if (  $numErrors == 1 ) {//TODO meter clase de error en el primer UL (tarjeta_roja)
            $html .= "<ul class = 'tarjeta_roja' id="."printError"."><li class="."error"."><p>".$errors[0]."</p></li></ul>";
        } else if ( $numErrors > 1 ) {
            $html .= "<ul><li><p>";
            $html .= implode("</p></li><li class="."error"."><p>", $errors);
            $html .= "</p></li></ul>";
        }
        return $html;
    }
}
