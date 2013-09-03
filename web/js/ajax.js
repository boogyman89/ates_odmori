$(document).ready(function() {
     
  //find requests  
  $('#filterRequestButton').on('click', function(){
     
     //get name from worker name
     workerName = $('#requestWorkerName').val();
     workerLastName = $('#requestWorkerLastName').val();
     
     //alert(workerName+" "+workerLastName);
     
     $.post(EmpoloyeeVacation.routes.ajax_request_find_requests,{ name: workerName, last_name: workerLastName },  function(data) {
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
     $.post(EmpoloyeeVacation.routes.ajax_request_find_user, { name: workerName, last_name: workerLastName },  function(data) {
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
      //alert (EmpoloyeeVacation.routes.ajax_find_user_request_base);
        
        var filter = $(this).val();
        
        getUserRequests( filter, 1 );
    });
    
   function getUserRequests( filter, page )
   {
       $.get(EmpoloyeeVacation.routes.ajax_find_user_request_base + '/' + filter + '/' + page, function(data){
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
   }
    
   //intersept pagerfanta request on prolfile page
   $(document).on('click', '.pagination ul li a', function(){
        
       var page = $(this).text();
       var filter = $("#requestsFilterProfile").val();
             
        //if not a number
        if(isNaN(page))
        {
            //if is possible to go on clicked page
            if(!$(this).parent().hasClass('disabled'))
            {
                if($(this).parent().hasClass('next'))
                {
                    url = $(this).attr('href');
                    urlArr = url.split("/");
                    page = urlArr[urlArr.length - 1];
                }
                else if($(this).parent().hasClass('prev'))
                {
                    url = $(this).attr('href');
                    urlArr = url.split("/");
                    
                    if('all' == urlArr[urlArr.length - 1])
                        page = 1;
                    else
                        page = urlArr[urlArr.length - 1];
                }
            }            
        }
       getUserRequests( filter, page );
       return false;
   });
    
    
    
    
   
   $('.request-details a').on('click', function() {
       id = $(this).attr('id');
                  
       $.post('ajax/find_request_by_id', { id: id}, function(data){
           
            if(data !== '')
            {  
                $('#requestModal').html(data);           
            }
       });                
   });
   
   
   $('.rejectRequestLink').click(function(){
        id = $(this).attr('id');
        $('#confirmRejectModal').modal('toggle')
        
        $('.confirmRejectRequestButton').click(function(){
            window.location.href = 'http://localhost/app_dev.php/admin/reject_request/'+id;
        });
   });
   
    
   $('.deleteHoliday').click(function(){
        id = $(this).attr('id');
        $('#confirmDeleteHolidayModal').modal('toggle')

        $('.confirmDeleteHolidayButton').click(function(){
            window.location.href = 'http://localhost/app_dev.php/admin/delete_holiday/'+id;
        });
   });
   
   $('.deleteUser').click(function(){
        id = $(this).attr('id');
        $('#userDeleteModal').modal('toggle')

        $('.confirmDeleteUserButton').click(function(){
            window.location.href = 'http://localhost/app_dev.php/admin/delete_user_on_approving/'+id;
        });
   });
});