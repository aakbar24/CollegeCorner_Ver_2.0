$(document).ready(function()
{
  $('.forum-reply').click(function(e){
      e.preventDefault();
      console.log('clicked');
      
      var reply_id = $(this).siblings("[name='reply_id']").val();
      var username = $(this).closest('.forum-post').children('.forum-id-box').children('a').children('h4').html();
      
      var wysihtml5Editor = $('#Reply_message').data("wysihtml5").editor;
      $('#forum-replying-to').html(username);
      $('#forum-reply-indicator').show();
      $('#Reply_child_reply').val(reply_id);
      wysihtml5Editor.composer.element.focus();
      
  });
  
  $('.forum-report').click(function(e){
      e.preventDefault();

      var reply_id = $(this).siblings("[name='reply_id']").val();  
      var thread_id = $('#forum_id').val();

      showReportModal(thread_id, reply_id, "Why are you reporting this user's post?", $(this));
  });
  
   $('.forum-report-thread').click(function(e){
      e.preventDefault();
      
      var thread_id = $(this).siblings("[name='forum_id']").val();

      showReportModal(thread_id, null, "Why are you reporting this thread discussion?", $(this));
  });
  
  function showReportModal(thread_id, reply_id, header_text, sender)
  {
      var user_id = sender.closest('.forum-post').children('.forum-id-box').children('input').val();
       
      console.log(thread_id);  
      console.log(user_id); 
      console.log(reply_id); 
      
      $('#reportModal .modal-header h4').html(header_text);
      $('#reportModal [name="Complaint[post_item_id]"]').val(thread_id);
      $('#reportModal [name="Complaint[user_id]"]').val(user_id);
      $('#reportModal [name="Complaint[reply_id]"]').val(reply_id);
      $('#reportModal').modal('show');
  }
  
  $('.forum-child-reply-cancel').click(function(e){
      e.preventDefault();
      $(this).parent().hide();
      $('#Reply_child_reply').val(null);
  });
});  

