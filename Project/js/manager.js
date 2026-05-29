function actionLeave(id, action){

    fetch("leave_action.php", {
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id="+id+"&action="+action
    })
    .then(res=>res.json())
    .then(data=>{

        if(data.status==="success"){
            location.reload();
        } else {
            alert(data.message);
        }

    });

}