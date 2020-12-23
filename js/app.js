const app = new Vue({
     el: '#root',
      data: {   
         message: "this is just a demo", 
         user: null, 
         online:[],
         chatwith: null,
         messages: [], 
         signUp: true,
         menu: false     
    },
    methods: { 
    	handlesubmit: function(){
          this.user = $('#user').val() ; 	              	 
      },
      changeSigning: function (bol) {
        this.signUp = bol
      },
      getMessage: function () {
             
      },
      WhoIsOnline:function () {    
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
      }, 
      checkrequest:function () {
      },
      sendMessage: function(){
            this.messages.push({message: $('#msg-form').val(), id:12, to: false})  
        }); 
        $('#msg-form').val(' '); 
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
      alert('this is just a demo, works better with php involved')
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
