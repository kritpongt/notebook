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

### convert string data from fetch to php array backend
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

### loop perform in sequence (using await should be returning a promise)
```
async function fillCartItem(prods){
    for(let prod of prods){
        await cartActionPromise('add,ctrl-edit', prod.pcode, prod.qty)
    }
}

fillCartItem(products)
```

### convert a string php array to javascript object
```
const obj_data = JSON.parse('<?= json_encode($arr_data)?>')
```

### filter object keys that includes 'txt' and value > 0, and then return new objecet with reduce
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

### merge object
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

### 

# SQL

### group by and with rollup (summary row)
```
SELECT
    ah.id,
    ah.sano,
    ah.sadate,
    ah.total_pending_amount,
    sm.send_date,
    sm.send_amount,
    sm.send_status,
    sm.remark,
    sm.id AS sm_id,
    SUM(sm.send_amount) AS sum_sa
FROM
    ali_asaleh ah LEFT JOIN ali_send_money sm ON(sm.sano = ah.sano)
WHERE
    1 = 1 
GROUP BY
    ah.id,
    sm.id WITH ROLLUP

// Group the data by the sm.id column
// Calculate the sum of send_amount for each group at last row
// In rollup where column group by(sm.id) will show as NULL
```

### decorate the query group by with rollup
```
SELECT * 
FROM 
    (
    SELECT 
        r.id, 
        CASE WHEN r.sm_id IS NULL THEN CONCAT(r.sano, '') ELSE '' END AS sano, 
        CASE WHEN r.sm_id IS NULL THEN CONCAT(r.sadate, '') ELSE '' END AS sadate, 
        CASE WHEN r.sm_id IS NULL THEN FORMAT(r.total, 2) ELSE '' END AS total, 
        CASE WHEN r.sm_id IS NULL THEN FORMAT(r.total_pending_amount, 2) ELSE '' END AS diff, 
        CASE WHEN r.sm_id IS NOT NULL THEN CONCAT(r.sm_id, '') ELSE '' END AS sm_id, 
        CASE WHEN r.sm_id IS NOT NULL THEN CONCAT(r.send_date, '') ELSE '' END AS send_date, 
        CASE WHEN r.sm_id IS NOT NULL THEN CONCAT(r.send_amount, '') ELSE CONCAT(r.sum_sa, '') END AS send_amount, 
        CASE WHEN r.sm_id IS NOT NULL THEN CONCAT(r.send_status, '') ELSE chk_diff END AS send_status, 
        CASE WHEN r.sm_id IS NOT NULL THEN CONCAT(r.remark, '') ELSE '' END AS remark 
    FROM 
        (
        SELECT 
            ah.id, 
            ah.sano, 
            ah.sadate, 
            ah.total, 
            ah.total_pending_amount, 
            sm.send_date, 
            sm.send_amount, 
            sm.remark, 
            sm.id AS sm_id, 
            SUM(sm.send_amount) AS sum_sa, 
            CASE WHEN ah.total - SUM(sm.send_amount) <= 0 THEN '1' ELSE '2' END AS chk_diff 
        FROM 
            ali_asaleh ah 
            LEFT JOIN ali_send_money sm ON(sm.sano = ah.sano) 
        GROUP BY 
            ah.id, 
            sm.id WITH ROLLUP
        ) r 
    WHERE 
        r.id IS NOT NULL AND sadate between '2024-09-01' AND '2024-09-26'
    ) a 
GROUP BY 
    a.id, 
    a.sm_id 
ORDER BY 
    a.id DESC, 
    a.sano DESC, 
    a.sm_id ASC
```

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
- in explorer bar rename, copy, cut, delete
- list.find <ctrl + f>          (add "&& vim.active")
- Trigger Suggest <alt + i>     (add "&& vim.active")
- hideSuggestWidget <alt + i>   (add "&& vim.active")
- go next <ctrl + i>            (add "&& vim.active") -> handlekey disable <C-i>
- go back <ctrl + o>            (add "&& vim.active") -> handlekey disable <C-o>
```