

    window.onload = () =>{
    let formFilter =   document.getElementById("form-filters")
    let select = document.getElementById('filter')


    select.addEventListener('change', () =>{
    const form = new FormData(formFilter)

    const param =   document.getElementById('filter').value
    const url = window.location.href + '?' + 'p='+param + '&ajax=1'
    console.log(param)
    fetch(url,{
    headers:{
    "X-Reauested-With" : "X:LHttpRequest"
}
}).then(
    res  => res.json()
    ).then (
    data => {
    const container = document.getElementById('dynamiqBody')
    container.innerHTML = data.content
}
    ).catch( err => {
    alert(err)
}

    )

})

}

