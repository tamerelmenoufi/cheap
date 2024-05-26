Carregando = (opc = 'flex') => {
    $(".Carregando").css("display",opc);
    // alert(opc);
    // session = $("body").attr("session")
    // $.ajax({
    //     url:'lib/sessoes.php',
    //     type:"POST",
    //     data:{
    //         session
    //     },
    //     success:function(dados){
    //         // console.log(dados);
    //         $("body").attr("session", dados);
    //     }
    // });
}


historico = (opc)=>{
	Carregando();
	console.log(`Local: ${opc.local}`)
	console.log(`destino: ${opc.destino}`)
}



(function(window) {
    'use strict';

  var noback = {

      //globals
      version: '0.0.1',
      history_api : typeof history.pushState !== 'undefined',

      init:function(){
          window.location.hash = '#no-back';
          noback.configure();
      },

      hasChanged:function(){
          if (window.location.hash == '#no-back' ){
              window.location.hash = '#back';
			//   alert('acao1')
              $.ajax({
                url:"lib/voltar.php",
                dataType:"JSON",
                success:function(dados){
                    var data = $.parseJSON(dados.dt);

                    $.ajax({
                        url:dados.pg,
                        type:"POST",
                        data,
                        success:function(retorno){
                            $(`${dados.tg}`).html(retorno);
                        }

                    })
                }
              })
              //mostra mensagem que não pode usar o btn volta do browser
              //MensagemBack();
            //   PageClose();
          }
      },

      checkCompat: function(){
          if(window.addEventListener) {
              window.addEventListener("hashchange", noback.hasChanged, false);
          }else if (window.attachEvent) {
              window.attachEvent("onhashchange", noback.hasChanged);
          }else{
              window.onhashchange = noback.hasChanged;
          }
      },

      configure: function(){
          if ( window.location.hash == '#no-back' ) {
              if ( this.history_api ){
				// alert('acao3')
			  history.pushState(null, '', '#back');
              }else{
			//   alert('acao2')
			  window.location.hash = '#back';
                  //mostra mensagem que não pode usar o btn volta do browser
                  //MensagemBack();
                  //PageClose();
              }
          }
          noback.checkCompat();
          noback.hasChanged();
      }

      };

      // AMD support
      if (typeof define === 'function' && define.amd) {
          define( function() { return noback; } );
      }
      // For CommonJS and CommonJS-like
      else if (typeof module === 'object' && module.exports) {
          module.exports = noback;
      }
      else {
          window.noback = noback;
      }
      noback.init();
  }(window));





ultimaPosicao = 0;

function rolar(){
    var atualPosicao = window.scrollY;
    console.log(`${atualPosicao}`)
}

