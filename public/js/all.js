$(function(){
  
    var texto = '';
    document.addEventListener('copy', function(e) {
      // e.clipboardData is initially empty, but we can set it to the
      // data that we want copied onto the clipboard.

      e.clipboardData.setData('text/plain', texto);
      

      // This is necessary to prevent the current document selection from
      // being written to the clipboard.
      e.preventDefault();
    });
     
    // Executa o evento click no button
    $('#icone_busca').click(function(){
        // Seleciona o conteúdo do input
        //var texto = $('#cpfcnpj').value;
        texto = document.getElementById('cpfcnpj').value;
        texto = texto.replace(/\.|\/|\-/g, '');
        // Copia o conteudo selecionado

        
        document.execCommand('copy');
        //var copiar = document.execCommand('copy');
        // Verifica se foi copia e retona mensagem
        
        // Cancela a execução do formulário
        return false;
    });
});