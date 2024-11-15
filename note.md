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
    const qs = document.querySelector('#div-id')
    qs.innerHTML = data
    const scripts = qs.querySelectorAll('script')
    scripts.forEach(function(script){
        let newScript = document.createElement('script')
        newScript.textContent = script.textContent
        if(script.src){ newScript.src = script.src }
        document.body.appendChild(newScript)
        document.body.removeChild(newScript)
    })
})
// in php
<?
$data = $_POST['data'] ?>
<body>
    <?= $data?>
</body>
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

### loop perform in sequence (using an await should be return a promise)
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

### regex
```
// [...]        # charactor class: create a char set, match a single position any char in [ ], 
//                  Ex. [ABC] => matches char "A" OR "B" OR "C"
//                      [0-9] => matches a number 0-9
// (...)        # capture group: it used to return **matches group**,
//                  Ex. (?<year>\d{4})[-|/](?<month>\d{2})[-|/](?<day>\d{2})    => return a obj.group.year, obj.group.month
//                      ^\d+(\.\d{1,2})?$                                       => matche a number with 2 decimal places
// \d           # matches single number, equivalent to [0-9], `\D` not a number
// \w           # matches word (alphanumeric && underscore), equivalent to [A-Za-z0-9_]
// \s           # matches any whitespace char (spaces, tabs, linebreaks)
// . (Dot)      # matches any char except linebreak, equivalent to [^\n\r]
// ^<x>         # matches beginning with <x>
// $<x>         # matches end with <x>
// <x>?         # matches 0 or 1
// <x>*         # matches 0 or more of the preceding <x> token
// <x>+         # matches 1 or more of the preceding <x>
// <x>{n}       # matches the specified quantity of <x>,
//                  Ex. <x>{3,} => , meaning more than specified quantity
//                      <x>{3,5} => match 3 to 5
// <x>|<y>      # matches <x> or <y>
// flag:   i    # ignore case
//         g    # global. without `/g` will stopping after the first match
//         m    # multi line
```

### regex methods
```
const str = 'test test test'
const pattern = /\S/g
const foo = pattern.test(str)   // return false / true
const bar = pattern.exec(str)   // return an array

str.search(pattern)             // return > -1
str.match(pattern)              // return an array / null
str.replace(pattern, 'renew')   // return new string with replacement made
```

### mutation observe + debounce function
```
function debounce(callback, delay){
    let timeout
    return function(...args){
        clearTimeout(timeout)
        timeout = setTimeout(function(){
            callback(...args)
        }, delay)
    }
}

function observeAndSetValue(id, value){
    let select = document.getElementById(id);
    if(select){
        const debSetValue = debounce(function(){
            select.value = value;
            select.dispatchEvent(new Event('change'));
        }, 300)
        const debDisconnect = debounce(function(){
            observer.disconnect();
        }, 1000)
        let observer = new MutationObserver((mutationList) => {
            debSetValue()
            debDisconnect()
        });
        observer.observe(select, { childList: true });
    }
}
```

### download file from server
```
fetch('path/file.xls').then(function(res){
    return res.blob()
}).then(function(data){
    const link  = document.createElement('a')
    const url   = URL.createObjectURL(blob)
    link.href = url
    link.download = 'file.xls
    link.click()
    URL.revokeObjectURL(url)
}).catch(err){
    console.error(err)
}
```

# JS DOM

### get all input elements by id
```
const form = document.getElementById('form')
const inputs = form.querySelectorAll('input, select, textarea')
```

### validate form
```
const form = document.getElementById('form')
form.checkValidity()        // true/false (in jquery `$('#form')[0].checkValidity()`)

const inputs = form.querySelectorAll('input, select, textarea')
inputs.forEach(input => {
    if(input.hasAttribute('required')){
        console.log(`Input '${input.name}' has required.`)
    }
    if(!input.checkValidity()){
        console.log(`Input '${input.name}' is invalid.`)
    }
});
```

# JQuery and other libaries

### select2 + btn in option
```
$("select[name='set_main_caddress']").select2({
    templateResult: function(option){
        if(option.id != ''){
            let $newOption = $(`<div> <button type="button" class="btn btn-default" onclick="manageCaddress('edit', ${option.id})"><i class="far fa-edit"></i></button> <button type="button" class="btn btn-default" onclick="manageCaddress('del', ${option.id})"><i class="far fa-trash-alt"></i></button> ${option.text}</div>`)
            return $newOption
        }
    }
}).on('select2:open', function(){
    $(this).val(null).trigger('change');
}).on('select2:selecting', function(e){
    if(e.params.args.originalEvent.target.tagName !== 'DIV') { e.preventDefault() }
}).on('select2:close', function(e){ })
```

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

### array built-in function
```
// array_column()
$arr_base = array(
    [
        'id'    => '1',
        'name'  => 'name_1',
    ],
    [
        'id'    => '2',
        'name'  => 'name_2',
    ]
);
$arr_new = array_column($arr_base, 'id');

// array_filter()
$arr_test = array( 'total', 'send_amount', 'diff', 'status' );
$arr_tmp = ['diff', 'status'];
$arr_new = array_filter($arr_test, function($item) use($arr_tmp){
    return !in_array($item, $arr_tmp);
});

// array_map()
$arr_test = array( '1', '2', '3', '4', '5' );
$arr_new = array_map(function($value){
    if($value % 2 == 0){ return 'ZERO'; }
    return $value;
}, $arr_test);

// array_reduce()
$arr_new = array_reduce($arr_test, funciton($result, $value){
    $result[] = $value % 2;
    return $result;
}, [])

// array_unshift()   # add value to beginning element
// array_shift()     # remove value beginning element
// array_push()
// array_pop()

// current()         # return begining value of an array
// next()            # move to next element
// prev()            # move to previous element
// end()             # return last value of an array
// reset()           # move to first element of the array

array_merge()   ?
array_replace() ?
```

### encryption
```
```

### less than 0 to be equal to 0
```
$value = -2;
$value = max(0, $value);
```

### display float number (string)
```
$float_number = sprintf('%.2f', 12.12);
```

### float number
```
$roundf = round(123.345, 2);            // 123.35
$ceilf = ceil((10000 / 3) * 100) / 100; // 3333.34
$floorf = floor(5680.555 * 100) / 100;  // 5680.55
```

# MySQL

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

// Group the data by the `ah.id` and `sm.id` column
// Calculate the sum of send_amount for each group at last row
// In rollup where column group by `sm.id` will show as NULL
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
            CASE WHEN ah.total - (SELECT SUM(send_amount) FROM ali_send_money sm2 WHERE sm2.sano = ah.sano ) <= 0 THEN '1' ELSE '2' END AS chk_diff 
        FROM 
            ali_asaleh ah 
            LEFT JOIN ali_send_money sm ON(sm.sano = ah.sano AND sm.send_status = '1') 
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

### NOT EXISTS (display records from one table where the id does not exist in another table)
```
SELECT id, column_name
FROM table1 t1
WHERE NOT EXISTS(SELECT 1 FROM table2 t2 WHERE t2.id = t1.id);
```

### count()
```
SELECT 
    COUNT(CASE WHEN status = '0' THEN id END) AS count 
FROM 
    table
GROUP BY 
    id
```

# PowerShell

### list all files including hidden
```
ls -Force
```

### remove hidden file
```
Remove-Item -Recurse -Force .git, .gitignore
```

# Git cycle
1. git pull origin <main_branch>                # synchronize the branch that lastest ver of the project.
2. git checkout -b <feature/bugfix>             # create branch and work on new branch
3. git commit -m "descriptive commit" -- ./path/file.md
4. git push origin <branch_name>                # push current feature branch to remote.
--
5. git checkout <main_branch>                   # change to main branch
6. git pull origin <main_branch>                # synchronize
- merge:                                        # create a merge commit at main, that combines branch and main
    - git merge <branch_name>                   # merge feature branch into main branch
    - git push origin <main_branch> 
    - or create a pull request(PR) to merge into the main branch.
- rebase: 
    - git checkout <branch_name>                # 
    - git rebase <main_branch>                  #
    - git push origin <main_branch>             #
- when feature branch has been successfully merged, can delete them
    - git branch -d <branch_name>               # local delete.
    - git push origin --delete <branch_name>    # remote delete.

# Volcab & Sentence
```
update this english for clearity.
this keeps the branch organized.
```

# Vscode
- block comment                                     `<alt + shift + a`
- remaneFile                                        `<r>`
- deleteFile                                        `<d>`
- filesExplorer.copy                                `<y>`                   # add "&& !notebookEditorFocused"
- filesExplorer.cut                                 `<x>`
- filesExplorer.paste                               `<p>`
- list.toggleSelection                              `<v>`
- explorer.openAndPassFocus                         `<l>`
- split tabs                                        `<ctrl + \>`
- workbench.action.toggleEditorWidths               `<ctrl + shift + \>`    # editorFocus
- workbench.action.toggleMaximizedPanel             `<ctrl + shift + \>`    # panelFocus
- workbench.action.terminal.kill                    `<ctrl + w>`            # terminalFocus && terminalCount > 1
- workbench.action.focusPreviousGroup               `<ctrl + h>`
- workbench.action.focusNextGroup                   `<ctrl + l>`
- workbench.action.moveEditorToPreviousGroup        `<ctrl + k + h>`        # editorFocus && !suggestWidgetHasFocusedSuggestion && vim.active
- workbench.action.moveEditorToNextGroup            `<ctrl + k + l>`        # editorFocus && !suggestWidgetHasFocusedSuggestion && vim.active
- list.find                                         `<ctrl + f>`
- go to matching tag                                `<<leader> + t>`
- window.customMenuBarAltFocus                                              # false
- editor.emmet.action.balanceIn                     `<alt + i>`
- editor.emmet.action.balanceOut                    `<alt + o>`
- editor.emmet.action.wrapWithAbbreviation          `<alt + u>`
- editor.emmet.action.removeTag                     `<alt + d`
- visual mode paste without override                                        # NonRecursive
- editor.action.moveSelectionToPreviousFindMatch    `<ctrl + shift + n>`    # editorFocus
- -liveshare.join                                   `<ctrl + alt + j>`      # remove
- -bookmarks.toggle                                 `<ctrl + alt + k>`      # remove