const url = 'http://laragram.com.devel';

window.addEventListener('load', function () {
    $('.heart').css('cursor', 'pointer');

    $('.heart').click(function () {

        if ($(this).hasClass("like")) {

            $(this).addClass('dislike').removeClass('like')

            $(this).attr('src', 'img/heart-trans.png')
            
              $.ajax({
               url:  url+'/dislike/'+$(this).data('id'),
               type: 'GET',
               success: function(response){
                   console.log(response);
               }
            });
            
            setTimeout(function(){ location.reload(); }, 10);

        } else {

            $(this).addClass('like').removeClass('dislike')

            $(this).attr('src', 'img/heart-red.png')
            
            $.ajax({
               url:  url+'/like/'+$(this).data('id'),
               type: 'GET',
               success: function(response){
                   console.log(response);
               }
            });
            
            setTimeout(function(){ location.reload(); }, 10);

        }

    });
    
    
    //Buscador
    const search = $('#search');
    $('#buscador').submit(function(){
       $(this).attr('action', url+'/gente/'+search.val());
    });
});