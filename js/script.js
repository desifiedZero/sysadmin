function newlead(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $("#newlead").attr("action"),
        data: $("#newlead").serialize(), 
        success: res => {
            console.log(res);
            if(!res.ok){
                throw Error("Unsuccessful");
            }
            document.querySelector('#leadname').value = '';
            document.querySelector('#leadphone').value = '';
            let leads = document.getElementById('leads');
            let tmp = leads.innerHTML;
            leads.innerHTML = `
                <tr>
                    <td>${res.leadName}</td>
                    <td>${res.leadPhone}</td>
                    <td>${res.status}</td>
                    <td>${res.timestamp}</td>
                </tr>
            `;
            leads.innerHTML += tmp;
        },
        error: err => {
            alert(err.responseJSON.error);
            console.log(err.responseJSON);
        }
    });
}

function printerDiv(divID) {    
    var divElements = document.getElementById(divID).innerHTML;
    var oldPage = document.body.innerHTML;

    document.body.innerHTML = 
        "<html><head><title></title></head><body>" + 
        divElements + "</body>";

    window.print();

    document.body.innerHTML = oldPage;
}