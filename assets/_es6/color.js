$( document ).ready(function() {
  $( "input[name='sitetheme']" ).on('change', function(){
    var theme = $(this).val();
      $('body').waitMe({
      effect : 'bounce',
      waitTime : 700,
      onClose : function() {
        $('#sitetheme').attr('href' , 'assets/css/theme-'+theme+'.css');
      }
    });
  });
});