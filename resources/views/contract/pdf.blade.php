<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
    {{--<link href="{{public_path('css/core.css')}}" rel="stylesheet"> --}}
    <title>Contrato</title>

    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 50px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            /** Extra personal styles **/
        
            color: white;
            text-align: center;
            line-height: 35px;
            margin-bottom: 1000px;
        }

        footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 

            /** Extra personal styles 
            text-align: center;
            line-height: 35px;
            **/
        }
    </style>
  </head>
  <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img src="{{public_path('/logo.png')}}" alt="" width="70">  
            
        </header>
        
        <footer>
            <img class="float-left" src="{{public_path('/logo.png')}}" alt="" width="70">  

            <img class="float-right" src="{{public_path('/logo.png')}}" alt="" width="70">  

            <div style="font-size: 0.7em;" class="text-center">
                SATCV SOCIEDAD ANONIMA <br>
                Calles: Vicente Rocafuerte 3-47 entre Grijalva y Borrero <br>
                Teléfono: 0991145742/0960815241 <br>
                Ruc: 1091788388001
            </div>

            
        </footer>

        <div class="mb-5"></div>

        <h1 class="h5 text-center"><b><u>CONTRATO DE PORTAFOLIO DE FONDO DE INVERSION
            SATCV S.A
            </u></b></h1>
        <br>
        @php
        setlocale(LC_ALL, 'es');
        @endphp
        <p>En la ciudad de Quito a los {{\Carbon\Carbon::now()->format('d')}}  días del mes de {{strftime("%B", \Carbon\Carbon::createFromFormat('!m',\Carbon\Carbon::now()->format('m'))->getTimestamp())}} del {{\Carbon\Carbon::now()->format('Y')}}, convienen en celebrar el presente Contrato De Inversión, por una parte, en calidad <b>GESTOR</b> la Sociedad Anónima SATCV con número de RUC. No. 1091788388001 representado por el señor CARLOS GERMAN MUÑOZ JARA portador de la cédula de ciudadanía Nro. 105007768-2, en calidad de PRESIDENTE; y por otra parte en calidad de <b>INVERSIONISTA</b> la o el señor@ {{$contract->user()->name}} portador de la cédula de ciudadanía Nro.………; La parte <b>GESTORA</b> es de nacionalidad ecuatoriana, mayores de edad, domiciliadas en la ciudad de Ibarra Provincia de Imbabura, hábiles y capaces para contratar y obligarse, y la parte <b>INVERSIONISTA</b> es de nacionalidad …………, portador de la cédula o pasaporte  Nro.  ….………,  domiciliada  en la dirección………………….., mayor de edad, hábil y capaz de contratar y obligarse y en forma conjunta suscriben el presente contrato al tenor de las siguientes cláusulas:</p>
        
        <p><b>PRIMERA: ANTECEDENTES. –</b> Las Partes de Forma libre y voluntaria, deciden crear un Instrumento Jurídico con el fin de que de forma conjunta se realicen actividades comerciales licitas, que permitan el incremento patrimonial del capital asociado por las partes a través de la ejecución de una o varias operaciones mercantiles que podrán ser bursátiles, extrabursátiles o comerciales, de manera continua hasta el fin del presente contrato, que dichas actividades se realizaran de manera directa por el <b>GESTOR</b> o también podrán ser ejecutadas por terceros elegidos por él y debidamente autorizados por de manera escrita.</p>

        <p><b>SEGUNDA: OBJETO. –</b> La parte <b>INVERSIONISTA</b>, de forma libre y voluntaria decide invertir y confiar su dinero a la Sociedad Anónima SATCV al portafolio de inversión (SATCV S.A). La <b>INVERSIONISTA</b> declara que la Sociedad Anónima conoce y se dedica de forma legal y transparente a la actividad antes señalada, para lo cual al ser un Contrato de Inversión se estipulan lo siguientes parámetros. -</p>

        <ol type="a">
            <li>El presente contrato no es un contrato de administración de recursos de terceros de manera ilimitada que por el contrario es un contrato que regula la <u><i>asociación</i></u> temporal para casos determinados, con fines de ejecutar operaciones comerciales y bursátiles a través de los canales y medios permitidos por la ley con entidades que cuenten con los controles pertinentes.</li>

            <li>Cuando se hace referencia a que las operaciones bursátiles o cualquiera comercial que deba ejecutarse por personal o entidades reguladas por la ley, se entenderá que serán por ejemplo el SRI, o entidad de control en el país donde se opere y en su defecto las que establezca la ley TRIBUTARIA (en el caso de ECUADOR).</li>

            <li>Las actividades descritas no tienen relación alguna con la compra de acciones de SATCV S.A, ya que el presente Instrumento se lo realiza con la finalidad de que SATCV S.A, tenga y cuente con los fondos necesarios para su plan de INVERSION y su desempeño en el mercado a la cual se destina y realiza sus actividades.</li>
        </ol>

        <p><b>TERCERA: MONTO. -</b>Las partes libre y voluntariamente convienen fijar el monto de la inversión en la cantidad de {{$contract->invested}}$ DOLARES DE LOS ESTADOS UNIDOS DE AMERICA, que el <b>INVERSIONISTA</b> los entrega de contado y en dinero en efectivo, y en moneda de curso legal, y que por su parte el <b>GESTOR</b> declara tenerlo recibido a satisfacción, confesión que no admite prueba en contrario. –</p>

        <p><b>CUARTA: BENEFICIO. -</b> Con estos antecedentes, La Sociedad Anónima en calidad de <b>GESTOR</b>, tiene a bien por medio del presente instrumento dar en beneficio real a favor del inversionista la cantidad correspondiente hasta
            5% mensual de su inversión total, transferencia que lo realizan a perpetuidad y
            libre de todo gravamen, durante el período de 12 meses consecutivos, pagando mensualmente la cantidad equivalente según el monto inicial invertido en $ dólares.
            </p>

        <p>El <b>INVERSIONISTA</b> deberá con la anticipación de 30 días hábiles informar al <b>GESTOR</b> su deseo de terminación del presente Instrumento, o en su defecto su nueva voluntad de generar una nueva Inversión.</p>

        <p>Se aclara que el Beneficio que generara la Inversión del presente Contrato solo corresponde al <b>INVERSIONISTA</b> y este mismo no puede ser cedido o endosado a ninguna otra persona ni a terceros, sin autorización expresa del <b>GESTOR.</b></p>

        <p>Se recuerda a las partes que intervienen en el presente instrumento que el período de inversión es de 12 meses A partir de la firma del contrato, dejando el <b>INVERSIONISTA</b> su inversión de forma permanente el tiempo antes señalado. Debiendo de esta manera señalar que, si el <b>INVERSIONISTA</b> necesita, o toma la decisión de retirar su inversión antes del tiempo señalado, la parte <b>GESTORA</b>, toma un 20% del valor solicitado a retirar el cual será descontado de su capital actual.</p>

        <p>Siguiendo el mismo lineamiento, la parte <b>GESTORA</b>, se compromete a establecer un máximo riesgo de 20% sobre el valor capital, se tendrá en cuenta que la parte <b>GESTORA</b> tomando dicho riesgo llegase a tener este resultado, se hará procedencia a regresar el 80% inmediatamente al inversionista, de no ser asi por acuerdo mutuo se mantendrá el margen operativo.</p>

        <p><b>QUINTA: GARANTÍAS DE LAS PARTES. –</b> Las partes del presente contrato tienen a bien las siguientes garantías:</p>

        <ol>
            <li><b>El INVERSIONISTA</b>, tomara como una de sus garantías de su inversión, una letra de cambio que se firma por el monto total de su inversión, misma que se encuentra debidamente firmada y aceptada por el <b>PRESIDENTE</b> de SATCV. Pudiendo para el cobro de la misma adjuntar como prueba el presente instrumento.</li>

            <li>El <b>GESTOR</b>, por su parte tiene la garantía mencionada en la cláusula cuarta donde se especifica que, si el <b>INVERSIONISTA</b> decide retirar su fondo de inversión antes de la culminación del presente instrumento, el mismo tendrá una penalidad del 20% de su inversión.</li>
        </ol>

        <p>Las partes declaran que comprenden y aceptan de manera informada y libre que el presente contrato regula una situación de inversión, para lo cual se ratifican al final del instrumento con su firma.</p>

        <p><b>SUSCRIPCION Y RATIFICACION. -</b> Las partes contratantes se ratifican una vez más en su contenido y para que haga fe de ello, suscriben al pie del presente contrato de Compra de Inversión a los {{\Carbon\Carbon::now()->format('d')}}  días del mes de {{strftime("%B", \Carbon\Carbon::createFromFormat('!m',\Carbon\Carbon::now()->format('m'))->getTimestamp())}} del {{\Carbon\Carbon::now()->format('Y')}}, en caso de controversia, las partes se sujetas en primera instancia a conversaciones amigables, caso contrario renuncian al contrato y se sujetan a los jueces competentes de esta jurisdicción, así como al trámite legal respectivo.</p>        

        <p>Para constancia de todo lo estipulado en el presente Contrato de Inversión las partes suscriben el presente documento por duplicado, en unidad de acto.</p>

        <table class="" style="width: 100%;">
          <tbody>
            <tr>
              <th style="width: 50%;"><p class="text-center">Presidente</p></th>
              <td style="width: 50%;"><p class="text-center"></p></td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <p class="text-center"><img src="{{public_path('custom/firma_administrador.png')}}" alt="" width="250"></p>
              </td>
              <td style="width: 50%;">
                <p class="text-center"><img src="{{$contract->firma_cliente}}" alt="" width="250"></p>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;"><p class="text-center"><u>Carlos muñoz Jara</u></p></td>
              <td style="width: 50%;"><p class="text-center"><u>{{$contract->user()->name}}<u></p></td>
            </tr>
            <tr>
              <td style="width: 50%;"><p class="text-center"><u>105007768-2</u></p></td>
              <td style="width: 50%;"></td>
            </tr>
            <tr>
              <td style="width: 50%;"><p class="text-center"><b class="text-center">Gestor</b></p></td>
              <td style="width: 50%;"><p class="text-center"><b>Inversor</b></p></td>
            </tr>
          </tbody>
        </table>
  </body>
</html>