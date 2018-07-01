<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//  SITE NAME
define("SITE_NAME", "Buscar Autopeças");
define("SITE_SUBNAME", "3046 1100 - 99199 5058");
define("SITE_DESC", "Especialista em Assistência Técnica à ar-condicionado automotivo. Somos uma empresa autorizada Denso, Spheros, Euroar, Irizar e Valeo. Distribuimos não, somente, peças, mas, qualidade e confiabilidade!");


//  EMPRESAS PARCEIRAS
define("BUS_A_NAME","BusCar Refrigerações");
define("BUS_A_ADDR","Rua Ceará, 624.");
define("BUS_A_DISTRICT","Demócrito Rocha, Fortaleza-CE");
define("BUS_A_PHONE_A","85.3046.1100");
define("BUS_A_PHONE_B","85.9.9199.5058");
define("BUS_A_EMAIL","buscar.vendas@gmail.com");

define("BUS_B_NAME","DU AR Refrigeração");
define("BUS_B_ADDR","Av. Júlio Ventura, 1576A.");
define("BUS_B_DISTRICT","Aldeota, Fortaleza-CE");
define("BUS_B_PHONE_A","3261-4652");
define("BUS_B_PHONE_B","3261-4687");
define("BUS_B_EMAIL","duarrefrigeracao@gmail.com");

define("BUS_C_NAME","Center Ar Refrigeração");
define("BUS_C_ADDR","Rua Artur Temoteo, 243.");
define("BUS_C_DISTRICT","Bairro de Fátima, Fortaleza-CE");
define("BUS_C_PHONE_A","3211-0037");
define("BUS_C_PHONE_B","");
define("BUS_C_EMAIL","center.ar@centerar.com.br");


/*
* E-MAIL SERVER
* Consulte estes dados com o serviço de hospedagem
*/
define('MAIL_HOST', 'smtp.gmail.com'); //Servidor de e-mail ex.: mail.dominio.com.br
define('MAIL_PORT', '465'); //Porta de envio ex.: 25
define('MAIL_USER', 'contatossitens@gmail.com'); //E-mail de envio ex.: contato@inforstorm.com.br
define('MAIL_PASS', '<bHW6-9cXYPH>{Xa'); //Senha do e-mail de envio ex.: 12345
define('MAIL_SENDER', 'Grupo BusCar Autopeças'); //Nome do remetente de e-mail ex.: Inforstorm Desenvolvimento web
define('MAIL_TESTER', ''); //E-mail de testes (DEV) ex.: jpgjoaopaulo95@hotmail.com
define('MAIL_CRYPTO', 'ssl'); // ssl, tls

define("ADMIN_NAME", "Dashboard");
/*
 * MEDIA CONFIG
 */
define('IMAGE_W', 1600); //Tamanho da imagem (WIDTH)
define('IMAGE_H', 800); //Tamanho da imagem (HEIGHT)
define('THUMB_W', 800); //Tamanho da miniatura (WIDTH) PDTS
define('THUMB_H', 1000); //Tamanho da minuatura (HEIGHT) PDTS
define('AVATAR_W', 500); //Tamanho da miniatura (WIDTH) USERS
define('AVATAR_H', 500); //Tamanho da minuatura (HEIGHT) USERS
define('SLIDE_W', 1920); //Tamanho da miniatura (WIDTH) SLIDE
define('SLIDE_H', 600); //Tamanho da minuatura (HEIGHT) SLIDE
define("IMAGE_BRAND_W", 600);
define("IMAGE_BRAND_H", 600);

/*
  AGENCY DATA
  Dados da sua agência web
 */
define("AGENCY_CONTACT", "João Paulo do Nascimento Freitas"); //Nome do contato
define('AGENCY_EMAIL', 'jpgjoaopaulo95@hotmail.com'); //E-mail de contato
define('AGENCY_PHONE', '(85) 98412-9337'); //Telefone de contato
define('AGENCY_URL', 'https://www.inforstorm.com.br'); //URL completa do seu site/portfolio
define("AGENCY_NAME", "Inforstorm®"); //Nome da sua agência web
define('AGENCY_ADDR', 'Av. Tabatinga, 1191'); //Endereço da sua agência web (RUA, NÚMERO)
define('AGENCY_CITY', 'Maranguape');  //Endereço da sua agência web (CIDADE)
define('AGENCY_UF', 'CE');  //Endereço da sua agência web (UF DO ESTADO)
define('AGENCY_ZIP', '61950-990');  //Endereço da sua agência web (CEP)
define('AGENCY_COUNTRY', 'Brasil');  //Endereço da sua agência web (PAÍS)
define("AGENCY_YEAR_DEV", "2018");


define("E_PDT_LIMIT", 0);

/*
 * TABELAS
 */
define('DB_CONF', 'ws_config'); //Tabela de Configurações
define('DB_USERS', 'ws_users'); //Tabela de usuários
define('DB_USERS_ADDR', 'ws_users_address'); //Tabela de endereço de usuários
define('DB_USERS_NOTES', 'ws_users_notes'); //Tabela de notas do usuário
define('DB_POSTS', 'ws_posts'); //Tabela de posts
define('DB_POSTS_IMAGE', 'ws_posts_images'); //Tabela de imagens de post
define('DB_CATEGORIES', 'ws_categories'); //Tabela de categorias de posts
define('DB_SEARCH', 'ws_search'); //Tabela de pesquisas
define('DB_PAGES', 'ws_pages'); //Tabela de páginas
define('DB_PAGES_IMAGE', 'ws_pages_images'); //Tabela de imagens da página
define('DB_COMMENTS', 'ws_comments'); //Tabela de Comentários
define('DB_COMMENTS_LIKES', 'ws_comments_likes'); //Tabela GOSTEI dos Comentários
define('DB_PDT', 'ws_products'); //Tabela de produtos
define('DB_PDT_STOCK', 'ws_products_stock'); //Tabela de estoque por variação
define('DB_PDT_IMAGE', 'ws_products_images'); //Tabela de imagem de produtos
define('DB_PDT_GALLERY', 'ws_products_gallery'); //Tabela de galeria de produtos
define('DB_PDT_CATS', 'ws_products_categories'); //Tabela de categorias de produtos
define('DB_PDT_BRANDS', 'ws_products_brands'); //Tabela de fabricantes/marcas de produtos
define('DB_PDT_COUPONS', 'ws_products_coupons'); //Tabela de Cupons de desconto
define('DB_ORDERS', 'ws_orders'); //Tabela de pedidos
define('DB_IMOBI', 'ws_properties'); //Tabela de imóveis WS IMOBI
define('DB_IMOBI_GALLERY', 'ws_properties_gallery'); //Tabela de galeria de imóveis
define('DB_SLIDES', 'ws_slides'); //Tabela de conteúdo em destaque
define('DB_ORDERS_ITEMS', 'ws_orders_items'); //Tabela de itens do pedido
define('DB_VIEWS_VIEWS', 'ws_siteviews_views'); //Controle de acesso ao site
define('DB_VIEWS_ONLINE', 'ws_siteviews_online'); //Controle de usuários online
define('DB_WC_API', 'workcontrol_api'); //Controle de api do WC
define('DB_WC_CODE', 'workcontrol_code'); //Controle de code de WC



/*
 * Parcelamento
 */
define('ECOMMERCE_PAY_SPLIT', 1); //Aceita pagamento parcelado?
define('ECOMMERCE_PAY_SPLIT_MIN', 5); //Qual valor mínimo da parcela? (consultar método de pagamento)
define('ECOMMERCE_PAY_SPLIT_NUM', 12); //Qual o número máximo de parcelas? (consultar método de pagamento)
define('ECOMMERCE_PAY_SPLIT_ACM', 2.99); //Juros aplicados ao mês! (consultar método de pagamento)
define('ECOMMERCE_PAY_SPLIT_ACN', 1); //Parcelas sem Juros (consultar método de pagamento)

//CLIENTE

/*
     * SHIP CONFIG
     * DADOS DO SEU CLIENTE/DONO DO SITE
     */
define('SITE_ADDR_NAME', 'BusCar Autopeças'); //Nome de remetente
define('SITE_ADDR_RS', 'BusCar'); //Razão Social
define('SITE_ADDR_EMAIL', 'contato@redebuscar.com.br'); //E-mail de contato
define('SITE_ADDR_SITE', ''); //URL descrita
define('SITE_ADDR_CNPJ', '00.000.000/0000-00'); //CNPJ da empresa
define('SITE_ADDR_IE', '000/0000000'); //Inscrição estadual da empresa
define('SITE_ADDR_PHONE_A', '85 3046 1100'); //Telefone 1
define('SITE_ADDR_PHONE_B', '85 9.9199.5058'); //Telefone 2
define('SITE_ADDR_ADDR', ''); //ENDEREÇO: rua, número (complemento)
define('SITE_ADDR_CITY', ''); //ENDEREÇO: cidade
define('SITE_ADDR_DISTRICT', ''); //ENDEREÇO: bairro
define('SITE_ADDR_UF', ''); //ENDEREÇO: UF do estado
define('SITE_ADDR_ZIP', ''); //ENDEREÇO: CEP
define('SITE_ADDR_COUNTRY', ''); //ENDEREÇO: País


    /**
     * Social Config
     */
    define('SITE_SOCIAL_NAME', '');
    /*
     * Google
     */
    define('SITE_SOCIAL_GOOGLE', 1);
    define('SITE_SOCIAL_GOOGLE_AUTHOR', ''); //https://plus.google.com/????? (**ID DO USUÁRIO)
    define('SITE_SOCIAL_GOOGLE_PAGE', ''); //https://plus.google.com/???? (**ID DA PÁGINA)
    /*
     * Facebook
     */
    define('SITE_SOCIAL_FB', 1);
    define('SITE_SOCIAL_FB_APP', 0); //Opcional APP do facebook
    define('SITE_SOCIAL_FB_AUTHOR', ''); //https://www.facebook.com/?????
    define('SITE_SOCIAL_FB_PAGE', ''); //https://www.facebook.com/?????
    /*
     * Twitter
     */
    define('SITE_SOCIAL_TWITTER', ''); //https://www.twitter.com/?????
    /*
     * YouTube
     */
    define('SITE_SOCIAL_YOUTUBE', ''); //https://www.youtube.com/user/?????
    /*
     * Instagram
     */
    define('SITE_SOCIAL_INSTAGRAM', ''); //https://www.instagram.com/?????
    /*
     * Snapchat
     */
    define('SITE_SOCIAL_SNAPCHAT', ''); //https://www.snapchat.com/add/?????