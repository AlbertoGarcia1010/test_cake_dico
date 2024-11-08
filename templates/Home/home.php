<h1>Bienvenido</h1>

<h2>Tipo de cambio al día</h2>
<p><span id="title"></span></p>
<p><span id="date"></span></p>
<p><span id="data"></span></p>



<script type="text/javascript">
    $(document).ready(function() { 
        $.ajax({
            url: '/home/money',
            // url: 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno',
            async: 'true',
            type: 'GET',
            // dataType: 'json',
            headers: {
                'contentType': 'application/json',
                // 'Bmx-Token': 'c92a8b0616477f31fbe28efb42a087d272093b9befe342f944b6eb64aa8607e5',

                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                $('#title').text(response.bmx.series[0].titulo);
                $('#date').text(`Al día: ${response.bmx.series[0].datos[0].fecha}`);
                $('#data').text(`$ ${response.bmx.series[0].datos[0].dato}`);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>