
   
    var likebtn = document.getElementsByClassName("likepost")
    var countlikepost = document.getElementsByClassName("countlikepost")

    var comuntbtn = document.getElementsByClassName("osama")
    var commentinp = document.getElementsByClassName("commentinp")
    var countomments = document.getElementsByClassName("countomments")
    var commentcontainer = document.getElementsByClassName("commentcontainer")
    var postcomment = document.getElementsByClassName("postcomment")
    var deletecomment = document.getElementsByClassName("deletecomment")
    var deletecommentlen = deletecomment.length
    var btnlen = comuntbtn.length
    var likebtnlen = likebtn.length
    var page = document.getElementsByTagName("title")[0].innerText
    // loading data until scrolling

    if(page === 'Home' || page === 'Profile'){
      userid = (page === 'Home') ? "" : document.getElementById('user-img').getAttribute('getid')
      var loading = false;
      var offset = 0;
      var postscontainer = document.getElementById("posts-container")
      if(postscontainer){
        projectcount = postscontainer.getAttribute("count")
      }
      
      $(window).scroll(function() {
        check = projectcount - 3 - offset
        if (!loading && $(window).scrollTop() + $(window).height() >= $(document).height() - 100 && check > 0) {
          loading = true
          offset   += 3
          data    = []
          data[0] = offset
          data[1] = page
          data[2] = userid
          $.ajax({
            url: 'http://reavlme.local/',
            type: 'POST',
            data: { controller : 'AjaxControl', method: 'getProjects' , params : data},
            success: function(response) {
              $('#posts-container').append(response);
              
              var likebtn = document.getElementsByClassName("likepost")
              var countlikepost = document.getElementsByClassName("countlikepost")
              
              var comuntbtn = document.getElementsByClassName("osama")
              var commentinp = document.getElementsByClassName("commentinp")
              var countomments = document.getElementsByClassName("countomments")
              var commentcontainer = document.getElementsByClassName("commentcontainer")
              var postcomment = document.getElementsByClassName("postcomment")
              var deletecomment = document.getElementsByClassName("deletecomment")
              
              var newdeletecommentlen = deletecomment.length
              var newbtnlen = comuntbtn.length
              var newlikebtnlen = likebtn.length
              
              
              for (var l = deletecommentlen; l < newdeletecommentlen; l++){
                  deleteCommmentEvent(deletecomment[l],postcomment[l]);
                }
                deletecommentlen = newdeletecommentlen
                
                for (var j = btnlen; j < newbtnlen; j++){
                  addCommmentEvent(comuntbtn[j],commentinp[j],countomments[Math.floor(j/2)],commentcontainer[Math.floor(j/2)]);
                }
                btnlen = newbtnlen
                
                for (var k = likebtnlen; k < newlikebtnlen; k++){
                  addLikeEvent(likebtn[k],countlikepost[k])
                }
                likebtnlen = newlikebtnlen
                loading = false;
              }
          });
        }
    });
  }  
    
    

    let addfriend = document.getElementById("addfriend")
    if(addfriend){
      let status = addfriend.getAttribute("status")
      if(status == 0 ){
        addfriend.style.backgroundColor = "red"
        document.getElementById("spantext").innerText = "delete request" 
      }else if(status == 1){
        document.getElementById("spantext").innerText = "friend" 
      }else if(status == 2){
        document.getElementById("spantext").innerText = "confirm" 
      }
      addfriend.addEventListener("click", function(event){
        console.log(status)
        let data = []
        data[0] = this.getAttribute("getid")
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'friendHandeler' , params : data }, 
          dataType: 'text', 
          success: function(response) {
            console.log(response)
            if(response == 0 ){
              addfriend.style.backgroundColor = "red"
              document.getElementById("spantext").innerText = "delete request" 
            }else if(response == 3){
              addfriend.style.backgroundColor = "rgb(23, 162, 184)"
              document.getElementById("spantext").innerText = "Add friend" 
            }
            else if(response == 1){
              addfriend.style.backgroundColor = "rgb(23, 162, 184)"
              document.getElementById("spantext").innerText = "friend" 
            }
          },
          error: function(xhr, status, error) {
            window.alert(error)
          }
        })
      })
    }
  
  // confirm friend
    let confirmfriendbtn = document.getElementsByClassName("confirmfriendbtn")
    let confirmfriendcont = document.getElementsByClassName("confirmfriendcont")
    function addConfirmFriendEvent(confirmfriendbtn,confirmfriendcont) 
    {
      confirmfriendbtn.addEventListener("click", function(event) {
        let data = []
        data[0] = confirmfriendbtn.getAttribute("friendid")
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'confirmFriend' , params : data }, 
          dataType: 'text', 
          success: function(response){
              confirmfriendcont.style.display = "none"
          },
          error: function(xhr, status, error) {
              window.alert(error)
          }
        })
      })
    }
  
    for (var i = 0; i < confirmfriendbtn.length; i++){
      addConfirmFriendEvent(confirmfriendbtn[i],confirmfriendcont[i])
    }
  
  
  
  // Like Settings

    function addLikeEvent(likebtn,countlikepost) 
    {
        likebtn.addEventListener("click", function(event) {
        let data = []
        data[0] = likebtn.getAttribute("postid")
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'Likehandeler' , params : data }, 
          dataType: 'text', 
          success: function(response) {
              countlikepost.innerHTML = response
          },
          error: function(xhr, status, error) {
              window.alert(error)
          }
        })
      })
    }
  
    for (var k = 0; k < likebtnlen ;k++){
      addLikeEvent(likebtn[k],countlikepost[k])
    }
  
  // comments settings 
    function addCommmentEvent(comuntbtn,commentinp,countomments,commentcontainer) {
      comuntbtn.addEventListener("click", function(event) {
        data    = []
        data[0] = comuntbtn.getAttribute("postid")
        data[1] = commentinp.value
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'addComments' , params : data }, 
          dataType: 'text', 
          success: function(response) {
              commentinp.value = ""
              array = response.split("{thismydata}")
              countomments.innerHTML = array[0]
              commentcontainer.innerHTML = array[1] + commentcontainer.innerHTML
               
              postcomment = document.getElementsByClassName("postcomment")
              deletecomment = document.getElementsByClassName("deletecomment")
              deletecommentlen = deletecomment.length
              for (var l = 0; l < deletecommentlen; l++){
                deleteCommmentEvent(deletecomment[l],postcomment[l]);
              }
          },
          error: function(xhr, status, error) {
              window.alert(error)
          }
        })
      })
    }
  
    for (var j = 0; j < btnlen; j++){
        console.log()
      addCommmentEvent(comuntbtn[j],commentinp[j],countomments[Math.floor(j/2)],commentcontainer[Math.floor(j/2)]);
  
    }
    // 
  
  
    function deleteCommmentEvent(deletecomment,postcomment){
      deletecomment.addEventListener("click", function(event) {
        data    = []
        data[0] = deletecomment.getAttribute("commentid")
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'delComment' , params : data }, 
          dataType: 'text', 
          success: function(response){
              postcomment.style.display = "none"
          },
          error: function(xhr, status, error) {
              window.alert(error)
          }
        })
      })
    }
  
    for (var l = 0; l < deletecommentlen; l++){
      deleteCommmentEvent(deletecomment[l],postcomment[l]);
    }
  

    searchinput = document.getElementById('search-input');
    searchresults = document.getElementById('search-results');
    ulsearchresults = document.getElementById('ul-search-results');

    searchinput.addEventListener('input',function(){

        data    = []
        data[0] = searchinput.value
        $.ajax({
          url: "http://reavlme.local/",
          type: 'POST', 
          data: { controller : 'AjaxControl', method: 'userSrarch' , params : data }, 
          dataType: 'text', 
          success: function(response) {
            ulsearchresults.innerHTML = response 
          },
          error: function(xhr, status, error) {
              window.alert(error)
          }
        })



      searchresults.style.display = 'block'
      blurdiv = false
    })

    ulsearchresults.addEventListener('mouseenter',function(){
       blurdiv = false
      //  console.log(blurdiv)
      })
      ulsearchresults.addEventListener('mouseleave',function(){
        blurdiv = true
        // console.log(blurdiv)
      })
      
    searchinput.addEventListener('blur',function(){
      console.log(blurdiv)
      if(blurdiv){
          searchresults.style.display = 'none'
      }
    })