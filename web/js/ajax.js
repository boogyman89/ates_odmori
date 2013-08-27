$(document).ready(function() {
  
  //popup for vacationrequest comment
  $('.comment').hover(function(){
     $('.comment').popover('destroy'); 
     $(this).popover('show');      
  }
  );
  
  //find requests  
  $('#filterRequestButton').on('click', function(){
     
     //get name from worker name
     workerName = $('#requestWorkerName').val();
     workerLastName = $('#requestWorkerLastName').val();
     
     //alert(workerName+" "+workerLastName);
     
     $.post('ajax/admin_find_requests',{ name: workerName, last_name: workerLastName },  function(data) {
         //alert('vraceno');
         if(data !== '')
         {
            $('#requestResults').html(data);
         }
         else
         {
              $('#requestResults').html('<h3>There is no requests for that user OR there is no user with that name!</h3>');
         }
      });
  });
  
  
  //find users
  $('#findUsersButton').on('click', function(){
     
     //get name from worker name
     workerName = $('#searchUserName').val();
     workerLastName = $('#searchUserLastName').val();
     
     //alert(workerName);
     $.post('ajax/admin_find_users',{ name: workerName, last_name: workerLastName },  function(data) {
         //alert(data);
         if(data !== '')
         {
            $('#usersResult').html(data);
         }
         else
         {
            $('#usersResult').html('<h3>There is no user with that name!</h3>');
         }
      });
  });
  
  
  
   //filter requests on profile page
   $("#requestsFilterProfile").on('change', function(){
      //alert ('promenjeno');
        
        var filter = $(this).val();
        
        $.get('../ajax/find_user_requests/'+filter, function(data){
            //alert(data);
            if(data !== '')
            {
               $('#userRequestResults').html(data);
                
            }
            else
            {
                $('#userRequestResults').html('<h3>There is no request with selected status ('+filter+')!</h3>');
            }
        });
    });
    
    
  
});