# JavaScript
### fetch
```
const url = '/';
fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: action, mcode: mcode })
}).then(function(res){
    return res.json()
}).then(function(data){

}).catch(function(err){
    console.log(err)
})

// in php
$postData = json_decode(file_get_contents('php://input'), true);
// ...
echo json_encode($postData);


// response text with php file
fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ data: data })
}).then(function(res){
    return res.text()
}).then(function(data){

})
// in php
<?
$data = $_POST['data'] ?>
<body><?= $data></body>
```

### convert string data from fetch to array in php backend
```
const data = JSON.stringify([{ 'key': 'value' }, { 'key': 'value' }])
// set header and body
headers: { 'Content-Type': 'application/json' },
body: JSON.stringify({ data: data })

// in php
$postData 	= json_decode(file_get_contents('php://input'), true);
$data 		= json_decode($postData['data'], true);
```

### promise
```
let order_filed = document.getElementById('order-field')
let inputs = document.querySelectorAll('#order-field input')
let obj_input = {}
const p = new Promise(function(resolve, reject){
    for(let input of inputs){
        if(input.name){ obj_input[input.name] = input.value }
    }
    resolve()
})

p.then(function(){ fetchData(obj_input) })

// as function
function assignObj(dom_inputs){
    let obj_input = {}
    return new Promise(function(resolve, reject){
        for(let input of dom_inputs){
            if(input.name){ obj_input[input.name] = input.value }
        }
        resolve(obj_input)
    })
}

assignObj(inputs).then(function(result){ fetchData(result) })

// function callback
function assignObjCallback(inputs, callback){
    let obj_input = {}
    const p =  new Promise(function(resolve, reject){
        for(let input of inputs){
            if(input.name){ obj_input[input.name] = input.value }
        }
        resolve()
    })
    p.then(function(){
        callback(obj_input)
    })
}

assignObjCallback(inputs, fetchData)
```

### loop perform in sequence (using await have to returning a Promise)
```
async function fillCartItem(prods){
    for(let prod of prods){
        await cartActionPromise('add,ctrl-edit', prod.pcode, prod.qty)
    }
}

fillCartItem(products)
```

### convert a php string array to javascript obj
```
const obj_data = JSON.parse('<?= json_encode($arr_data)?>')
```

### filter obj keys that includes 'txt' and then value > 0 and create new obj with reduce
```
const obj = {
    'txtCash': 100,
    'txtTransfer': 0,
    'name': 5
}

const arr_txt = Object.keys(obj)
    .filter(key => key.includes('txt') && obj[key] > 0)
    .reduce(function(result, key){
        result[key] = obj[key]
        return result
    }, {})
```

### merge obj
```
const merged_obj = Object.assign({}, obj_txt, obj_option, obj_select)
```

### 

# CSS
### showing an ellipsis (...)
```
.container {
    width: 100%; /* or any other width you need for the parent container */
}
.ellipsis-container {
    width: 40%;
    max-width: 70px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
```

# PHP

### senitize
```
```

### 

# PowerShell

### list all files including hidden
```
ls -force
```

### remove hidden file
```
Remove-Item -Recurse -Force .git
```

# Vscode
```
- split tabs
- split in group
```