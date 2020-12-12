const app = new Vue({
     el: '#root',
      data: {   
         message: "this is just a demo", 
         user: getCookie('username'), 
         online:[],
         chatwith: null,
         messages: [], 
         signUp: true,
         menu: false     
    },
    methods: { 
    	handlesubmit: function(){
    		let msg;
    		$.post('./inc/signup.inc.php',
    		{
               user: $('#user').val(),
               pwd:  $('#pwd').val()
    		}, function(data){		 
                app.message = data.msg;    
    		})   	              	 
      },
      changeSigning: function (bol) {
        this.signUp = bol
      },
      getMessage: function () {
         const vm = this;
         let start = 0; 
         function sendRequest () { 
          console.log('data sent') 
          $.get('./inc/addMessage.inc.php?start='+start+"&from="+vm.user+"&to="+vm.chatwith, function(data) {
            if (data.items) {
               data.items.forEach(item=>{
               start = item.id;
               vm.messages.push({message: item.message, id:item.who_to, to: false})                  
             }) 
           }
          });
           if (vm.chatwith != null){setTimeout(function(){sendRequest()},3000)};   
         }    
        sendRequest() ;      
      },
      WhoIsOnline:function () {    
       $.get('./inc/data.inc.php', function(areOnline) {
             app.online = [];          
             areOnline.forEach(function (isOnline) {
             app.online.push({name: isOnline.name, id:isOnline.id }) 
             this.checkrequest(); 
          }) 
       }); 
       let start = 0; 
      $.get("./inc/addMessage.inc.php?start="+start+"&from="+this.user+"&to"+app.chatwith ,function(data ,item) { 
       console.log(data)  
      });  
      },
      switchMsgdata:function () {
          let vm = this;
          this.messages.forEach(message =>{
          if (vm.chatwith == message.id){
             message.to = true  
          }
        })
      },
      startChat: function (index) {
        this.chatwith = this.online[index].id;      
        $.get('./inc/setrequest.inc.php?user='+this.user+"&to="+this.online[index].id, function(data) {
            notification.setNotification(data.msg, data.type)  
        });         
      }, 
      checkrequest:function () {
         $.get('./inc/checkrequest.inc.php?user='+this.user, function(data) {
            notification.setNotification(data.msg, data.type,data.id);    
         });
      },
      sendMessage: function(){
        $.post('./inc/addMessage.inc.php', {
          message: $('#msg-form').val(),
          from: this.user,
          to: this.chatwith
        }, function(data) {
            if (data.type == 'error'){notification.setNotification(data.msg, data.type)};
        }); 
        $('#msg-form').val(' '); 
      }, 
        handlelogin: function () {
         $.post('./inc/login.inc.php', 
            {
               user: $('#user-login').val(),
               pwd:  $('#pwd-login').val() 
            }, function(data){     
             if (data.type == 'success'){
          setCookie("username", data.user , 365);
                cookie = getCookie('username') ; 
                  app.user = cookie; 
                  nav.user = cookie; 
             }   
        })
        $('#user-login').val('')
         $('#pwd-login').val('')            
      },
       goBack: function () {
        this.chatwith = null
      },
      toCome: function () { 
        notification.setNotification('to be added soon', 'info') 
       },     
      logout: function () {
       this.user = null 
    },
    deleteAcc: function () {
      $.post('./inc/delete.inc.php', {user: this.user}, function(data) {
      notification.setNotification(data.msg, data.type)     
      });
      this.user = null; 
     } 
    }, 
    watch:{
      chatwith: function () {
        this.getMessage()
      },
      messages: function () {
        this.switchMsgdata();
      }
    }

});

// new vue instance
const nav = new Vue({ 
  el: '#nav',
      data: {   
         message: "",   
    },
methods:{ 
    toggleMenu: function () {
        app.menu = !app.menu ;         
      }
    } 
})

// new vue instance
const notification = new Vue({
  el: '#notify',
      data: {   
         message: "",    
         user: getCookie('username'),  
         isNotification: null, 
         error: false,  
         showbtn: false,
         btnId : ''
    },    
methods:{ 
     toggleNotification: function(){ 
        this.isNotification == true ? this.isNotification=null:this.isNotification=true;
       
     }, 
     setNotification: function(msg,type,id){
      this.toggleNotification();
       this.showbtn = false; 
       this.message = msg;
       switch (type){
        case 'error':
         this.error = true        
        break;
        case 'accept':
          this.showbtn = true;
          this.btnId = id;
        break;
          case 'info': 
          this.error = null
        break;        
        default:
         this.error = false
        break;
       }
     },
     accepted: function(){
       console.log(this.btnId)
       this.toggleNotification();
       app.chatwith = this.btnId; 
     }
   }
}) ;  
