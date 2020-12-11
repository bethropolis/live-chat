 let start = 0;
 $.get('./inc/addMessage.inc.php?start='+start+"&from="+app.user+"&to"+app.chatwith, function(result) {
        console.log(result);            
        result.items.forEach(item=>{
        start = item.id;
        app.messages.push({message: item.message,to:item.who_to,from:item.who_from})
       })
    load();
  });
 
