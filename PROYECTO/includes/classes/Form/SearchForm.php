<?php
//namespace es\ucm\fdi\aw;

require_once __DIR__.'/Form.php';
class SearchForm extends Form
{
    public function __construct() {
        parent::__construct('searchForm');
    }
    
    protected function generateFormFields($data)
    {
        $email = '';
        if ($data) {
            $search = isset($data['search']) ? $data['search'] : $search;
        }
        $html = <<<EOF
		<div class="tarjeta_gris">
        <p><input type="text" name="search" required placeholder="Busca por nombre, etiqueta o usuario">
            <input type='image' title="Buscar" alt="submit" src='includes/img/boton_BUSCAR.png'>
            <input type="image" name="reset" alt="reset" title="Borrar Campos" src='includes/img/boton_CLEAR.png'> 
			</p>
		</div>
EOF;
        return $html;
    }
    

    protected function processForm($data)
    {
        $app = es\ucm\fdi\aw\Application::getSingleton();
        $result = array();
        $search = isset($data['search']) ? $data['search'] : null;
        $conn = $app->bdConnection(); 
		$evento = new EventDAO($conn);
		
		if ( empty($search) ) {
			 $result[] = "El campo de busqueda ha de tener algo escrito";
		}
		
		else{
			$eventName='';
			$result = $evento->searchEventBy( $eventName , $search);
		}
		
	
		
        return $result;
    }
}