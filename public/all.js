$(function(){

     
    // Executa o evento click no button
    $('#icone_busca').click(function(){
        // Seleciona o conteúdo do input
        $('#cpfcnpj').select();
        // Copia o conteudo selecionado
        document.addEventListener('copy', function(e){
            e.clipboardData.setData('text/plain', 'Hello, world!');
            
            e.preventDefault(); // We want our data, not data from any selection, to be written to the clipboard
        });
        //var copiar = document.execCommand('copy');
        // Verifica se foi copia e retona mensagem
        
        // Cancela a execução do formulário
        return false;
    });
});