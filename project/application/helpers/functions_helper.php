<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('set_msg')):
    // SETA MENSAGEM VIA SESSION PARA SER EXIBIDA LIDA POSTERIORMENTE
    function set_msg($msg = null)
{
        $ci = &get_instance();
        $ci->session->set_userdata('aviso', $msg);
    }
endif;

if (!function_exists('get_msg')):
    // RETORNA UMA MENSAGEM DEFINIDA PELA FUNÇÃO SET_MSG
    function get_msg($destroy = true)
{
        $ci = &get_instance();
        $retorno = $ci->session->userdata('aviso');
        if ($destroy) {
            $ci->session->unset_userdata('aviso');
        }

        return $retorno;
    }
endif;

if(!function_exists('isTreatment')):
    /*
	 *
	 * TRATAMENTO DE LTRIM, TRIM, TAGS HTML
	 *
	 */
	function isTreatment($element){
		$Element = addslashes($element);
		$Element = strip_tags($Element);
		$Element = ltrim($Element);
		$Element = trim($Element);
		return $Element;
	}
endif;

//CONFIGURAÇÃO DE PAGINAÇÃO
if(!function_exists('config_pagination')):
    function config_pagination($url, $total_rows, $per_page, $first_link = false, $last_link = false)
    {
        // custom paging configuration
        $config = [
            'base_url'           => $url,
            'total_rows'         => $total_rows,
            'per_page'           => $per_page,
            'num_links'          => 2,
            'use_page_numbers'   => TRUE,        
            'full_tag_open'      => '<ul class="pagination justify-content-center m-t-0 m-b-5">',
            'full_tag_close'     => '</ul>',         
            'first_link'         => $first_link,
            'first_tag_open'     => '<li class="page-item">',
            'first_tag_close'    => '</li>',         
            'last_link'          => $last_link,
            'last_tag_open'      => '<li class="page-item">',
            'last_tag_close'     => '</li>',         
            'next_link'          => '<i class="fa fa-chevron-right"></i>',
            'next_tag_open'      => '<li class="page-item">',
            'next_tag_close'     => '</li>',
            'prev_link'          => '<i class="fa fa-chevron-left"></i>',
            'prev_tag_open'      => '<li class="page-item">',
            'prev_tag_close'     => '</li>',
            'cur_tag_open'       => '<li class="page-item active"><a href="javascript:;" class="page-link">',
            'cur_tag_close'      => '</a></li>',
            'num_tag_open'       => '<li class="page-item">',
            'num_tag_close'      => '</li>',
            'attributes'         => ['class' => 'page-link']
        ];

        return $config;
    }
endif;

//CONFIGURAÇÃO DE UPLOAD
if(!function_exists('config_upload')):
    function config_upload($path = './assets/uploads/', $types = 'jpg|png', $size = 1000, $folder = null){        
        if($folder):
            $config['upload_path'] = $path.$folder;
        else:
            $config['upload_path'] = $path;
        endif;        

        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
endif;

//CONFIGURAÇÃO DE CROP
if(!function_exists('config_crop')):
    function config_crop($path, $img, $width, $height, $imageSize){
        $config['source_image']   = $path.$img;        
        $config['allowed_types']  = 'jpg|png';
        $config['image_library']  = 'gd2';
        $config['maintain_ratio'] = FALSE;
        $config['quality'] = "100%";
        $config['width']          = $width;
        $config['height']         = $height;
        $config['x_axis']         = ($imageSize['width'] - $width) / 2;
        $config['y_axis']         = ($imageSize['height'] - $height) / 2;
        return $config;
    }
    //https://kennykee.com/138/codeigniter-resize-and-crop-image-to-fit-container-div-example/
endif;

// LIMPA CARACTER NO CPF E CNPJ
if (!function_exists('clean')):
    function clean($valor)
{
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }
endif;

if (!function_exists('validateCPF')):
    function validateCPF($cpf = null)
{

        // Verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = clean($cpf);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
    elseif ($cpf == '00000000000' ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999') {
        return false;

        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
    } else {

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}
endif;

// CONFIGURA A URL EX: teste-de-url
if (!function_exists('slug')):
    function slug($string)
{
        $String = (string) $string;
        $String = preg_replace('/[\t\n]/', ' ', $String);
        $String = preg_replace('/\s{2,}/', ' ', $String);

        $list = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C',
            'č' => 'c', 'Ć' => 'C', 'ć' => 'c', 'ç' => 'c', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A',
            'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y',
            'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'æ' => 'a', '@' => '-', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y',
            'Ŕ' => 'R', 'ŕ' => 'r', '#' => '-', '$' => '-', '%' => '-', '&' => '-', '*' => '-', '()' => '-',
            '(' => '-', ')' => '-', '_' => '-', '-' => '-', '+' => '-', '=' => '-', '*' => '-', '/' => '-',
            '\\' => '-', '"' => '-', '{}' => '-', '{' => '-', '}' => '-', '[]' => '-', '[' => '-', ']' => '-', '–' => '-',
            '?' => '-', ';' => '-', '.' => '-', ',' => '-', '<>' => '-', '°' => '-', 'º' => '-', 'ª' => '-',
            ':' => '-', '!' => '-', '@' => '-', ' ' => '-', '“' => '', '”' => '', '‘' => '', '’' => '',
            '"' => '',
        );

        $String = strtr($String, $list);
        $String = preg_replace('/-{2,}/', '-', $String);
        $String = strtolower($String);

        return $String;
    }
endif;
