setInterval(function(){ horaActual=new Date();
    hora=horaActual.getHours();
    minuto=horaActual.getMinutes();
    segundo=horaActual.getSeconds();

    horaimpre= hora + ":" + minuto+":"+ segundo;

    document.getElementById('hora').innerHTML = horaimpre; }, 1000);