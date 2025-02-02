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

### execute loop with sequential promises (using await waits for a promise in async function)
```
async function fillCartItem(prods){
    for(let prod of prods){
        await cartActionPromise('add,ctrl-edit', prod.pcode, prod.qty)
    }
}
fillCartItem(products)
```

### convert PHP Array to Javascript Object
```
const obj_data = JSON.parse('<?= json_encode($arr_data)?>')
```

### merge object
```
const merged_obj = Object.assign({}, obj_txt, obj_option, obj_select)
```

### filter object keys that includes 'txt' and value > 0, and then return new objecet with reduce
```
const obj = {
    'txtCash': 100,
    'txtTransfer': 0,
    'name': 5
}
const arr_txt = Object.keys(obj)
    .filter((key) => key.includes('txt') && obj[key] > 0)
    .reduce(function(result, key){
        result[key] = obj[key]
        return result
    }, {})

/* or do this */
const arr_txt = Object.entries(obj)
    .filter(([index, item]) => index.includes('txt') && obj[index] > 0)
let arr_result = Object.fromEntries(arr_txt)
```

### create an array of object
```
const obj = {
    1: 'G',
    2: 'GW,
    3: 'GC'
}
const arr_map = Object.entries(obj).map(([index, item]) => {
    return {id: index, text: item}
})
arr_map.forEach((item) => {
    console.log(item.id, item.text)
})
```

### regex
```
// [ ... ]      # Character Set: Match any single character inside the brackets
//                 Ex. [ABC] => Match 'A', 'B', or 'C'
//                     [0-9] => Match any digit from 0 to 9
// ( ... )      # Capturing Group: Groups tokens and captures the matched substring
//                 Ex. (?<year>\d{4})[-|/](?<month>\d{2})[-|/](?<day>\d{2})
//                     Returns obj.group.year, obj.group.month
// (?: ... )    # Non-Capturing Group: Groups tokens but does not capture the match
//                 Ex. (?:http|https):// => Match 'http://' or 'https://' but exclude from matches
// (?= ... )    # 
// \d           # Digit: Match a single digit (0-9). `\D` matches any non-digit
// \w           # Word Character: Match alphanumeric characters or underscore [A-Za-z0-9_]
// \s           # Whitespace: Match spaces, tabs, or line breaks
// . (Dot)      # Any Character: Match any character except line breaks
// ^<x>         # Start of String: Match if the string starts with <x>
// <x>$         # End of String: Match if the string ends with <x>
// <x>?         # Optional: Match 0 or 1 occurrence of <x>
// <x>*         # Zero or More: Match 0 or more occurrences of <x>
// <x>+         # One or More: Match 1 or more occurrences of <x>
// <x>{n}       # Exact Quantifier: Match exactly n occurrences of <x>
//                 Ex. <x>{3,} => Match 3 or more occurrences
//                     <x>{3,5} => Match 3 to 5 occurrences
// <x>|<y>      # Alternation: Match either <x> or <y>
// Flags: i     # Case-Insensitive Matching
//        g     # Global Match: Match all occurrences (stops after first match without `/g`)
//        m     # Multi-Line Mode: Match across multiple lines
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

### localStorage(), sessionStorage()
```
```

### websocket
```
```

# JS DOM

### get all input elements by id
```
const form = document.getElementById('form')
const inputs = form.querySelectorAll('input, select, textarea')
```

### find the child/parent element
```
// navigates in
let modal = document.getElementById('modal-stmt')
let modalTitle = modal.qeurySelector('.modal-title')
modalTitle.textContent = 'Set Title from top level'

// navigates up
let stmtIframe = document.getElementById('stmt-iframe')
let modalTitle = stmt_iframe.closest('.modal-content').querySelector('.modal-title')
modalTitle.textContent = 'Set Title from low level'
```

### validate form
```
const form = document.getElementById('form')
form.checkValidity()        
/** in jquery
 * $('#form')[0].checkValidity()
 */

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

### update options in select
```
function updSelectOptions(element, obj_options, val_selected = ''){
    const selectEl = document.getElementById(element)
    if(!selectEl || !obj_options){ return false }
    while(selectEl.firstChild){
        const child = selectEl.firstChild
        selectEl.removeChild(child)
    }
    Object.keys(obj_options).forEach((index) => {
        const opt = document.createElement('option')
        opt.value = index
        opt.textContent = obj_options[index]
        if(val_selected == index){ opt.selected = true }
        selectEl.appendChild(opt)
    })
}

function updSelectInnerHTML(el, optionHtml){
    const selectEl = document.getElementById(el)
    selectEl.options.length = 0
    selectEl.innerHTML = optionHtml
}
function optionsHTML(selectedVal = ''){
    const datenow = new Date()
    const year = datenow.getFullYear()
    let optionHtml = `<option value="">Select</option>`
    for(let i = 0; i >= 100; i++){
        const y = year - i
        optionHtml += `<option value="${y}" ${selectedVal = y ? 'selected': ''}>${y}</option>`
    }
    return optionHtml
}
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

### swal sweet alert2
```
swal({
    title: 'Are you sure?',
    text: '',
    showCancelButton: true,
    // confirmButtonColor: '#53E69D',
    confirmButtonText: 'OK',
    closeOnConfirm: false
}, function(){
    form.submit();
})

swal({
    title: 'แจ้งเตือน',
    text: '',
    type: 'warning',
    confirmButtonText: 'ยืนยัน',
    closeOnConfirm: true
})
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
$arr_new2 = array_column($arr_base, 'id', 'name');

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
// array_shift()     # remove value beginning element **and return the value**
// array_push()
// array_pop()

// current()         # return begining value of an array
// next()            # move to next element
// prev()            # move to previous element
// end()             # return last value of an array
// reset()           # move to first element of the array **and return the value `$first_element = reset($arr);`**

array_merge()   ?
array_replace() ?
// array_slice()    # (array, start, length)
$arr_left = array_slice($array, 0, 12);

// array_fill()      # fills an array with value (index, number, value)
```

### flatten array
```
function flattenArray($array){
    $result = [];
    foreach($array as $item){
        if(is_array($item)){
            $result = array_merge($result, flattenArray($item));
        }else{
            $result[] = $item;
        }
    }
    return $result;
}
```

### clear references &
```
foreach($data as &$val){
    //..
}
unset($val);
foreach($rs as $val){
    //..
}
```

### usort user-defined comparison function
```
$arr_queue = array(
    [ 'seq_no' => 98, 'name' => 'x' ],
    [ 'seq_no' => 80, 'name' => 'y' ],
    [ 'seq_no' => 12, 'name' => 'z' ]
);
usort($arr_queue, function($a, $b){
    return $a['seq_no'] <=> $b['seq_no'];
})
```

### range()
```
$arr = range(1, 5); // array(1, 2, 3, 4, 5);
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

### array destructuring (swap/update simultaneously)
```
$a = 24;
$b = 12;
[$a, $b] = [$b, $a + $b];
```

### generator (lazily yield), trigger with foreach, next()
```
function fibonacci($max){
    $a = 0;
    $b = 1;
    for($i = 0; $i < $max; $i++){
        yield $a;
        [$a, $b] = [$b, $a + $b];
    }
}
foreach(fibonacci(10) as $n){
    echo $n."\n";
}
```

### dp [F(n) = F(n-1) + F(n-2)]
```
// Tabulation (buttom-up)
function fibonacci($n){
    if($n <= 1){ return $n; }
    $dp = [0, 1];
    for($i = 2; $i <= $n; $i++){
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
    }
    return $dp[$n];
}

// Memoization (top-down)
function fibonacci($n, &$memo = []){
    if($n <= 1){ return $n; }
    if(isset($memo[$n])){ return $memo[$n]; }
    return $memo[$n] = fibonacci($n - 1, $memo) + fibonacci($n - 2, $memo);
}
```

### knapsack problem
```
$weights = [1, 3, 4, 5];
$values = [1, 4, 5, 7];
$capacity = 9;
$n = count($weights);

$dp = array_fill(0, $n + 1, array_fill(0, $capacity + 1, 0));
for($i = 1; $i <= $n; $i++){
    for($w = 1; $w <= $capacity; $w++){
        if($w < $weights[$i - 1]){
            $dp[$i][$w] = $dp[$i - 1][$w];
        }else{
            $dp[$i][$w] = max($dp[$i - 1][$w], $values[$i - 1] + $dp[$i - 1][$w - $weights[$i - 1]]);
        }
    }
}
$select = array();
$j = $capacity;
for($i = $n; $i > 0; $i--){
    if($dp[$i][$w] != $dp[$i - 1][$w]){
        $select[] = $i;
        $j -= $weights[$i - 1];
        if($j <= 0){ break; }
    }
}
echo 'maximum value: '.$dp[$n][$capacity];
echo 'selected: '.implode(', ', $select);
```

### binary search
```
function binary_search($arr, $target){
    $low, $high = 0, strlen($arr) - 1;
    while($low <= $high){
        $mid = ($low + $high);
        if($arr['mid'] == $target){
            return $arr['mid];
        }else if($arr['mid] < $target){
            $low = $mid + 1;
        }else{
            $high = $mid - 1;
        }
    }
    return false;
}
```

### iterator object
```
/**
 * 1. rewind
 * 2. valid
 * 3. current, key
 * 4. next
 * 5. valid
 */
class FileIterator implements Iterator{
    private $file;
    private $line;
    private $key;

    public function __construct($file_path){
        $this->file = fopen($file_path, 'r');
    }
    public function current(){
        return $this->line;
    }
    public function key(){
        return $this->key;
    }
    public function next(){
        $this->line = fgets($this->file);
        $this->key++;
    }
    public function rewind(){
        rewind($this->file); // set file pointer to 0
        $this->line = fgets($this->file);
        $this->key = 0;
    }
    public function valid(){
        return $this->line !== false;
    }
    public function __destruct(){
        fclose($this->file);
    }
}

$file = new FileIterator('example.txt');
foreach($file as $line_no => $line){
    echo $line_no.': '.$line;
}
```

### encryption
```
```

### include, require (always starts from the location of the PHP file that is running)
```
/**
 * 1. find in CWD
 * 2. find in default path(set_include_path())
 */
set_include_path(__DIR__."/libraries");
include('helper.php');
restore_include_path();

chdir('../document');
getcwd();
```

### get current url
```
$current_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$current_dir = dirname($current_url);
$backward_dir = dirname($current_dir);
$current_file = basename($current_url);
```

### set time limit (Maximum execution time exceeded.) default: 30s
```
set_time_limit(0);
sleep(5); // sleep 5s
```

### ini_set modify setting in php.ini
```
ini_set('memory_limit', '4069M');
echo memory_get_usage();
echo memory_get_peak_usage();
```

### add `.user.ini` file to a specific directory (php setting at the directory level, compatibility: CGI, FastCGI)
```
upload_max_filesize = 200M
post_max_size = 210M
```

# Composer

### download without GD (ignore any missing platform requirements)
```
composer require vender/package --ignore-platform-reqs
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

### case when in count function
```
SELECT 
    COUNT(CASE WHEN status = '0' THEN id END) AS count 
FROM 
    table
GROUP BY 
    id
```

### cross join return all records from both tables
```
SELECT 
    p.customer_price,
    (rp.max_cod * p.customer_price)AS price
FROM 
    products AS p
CROSS JOIN 
    (SELECT COALESCSE(MAX(cod), 0)AS max_cod FROM rate_point)AS rp;
```

### window function
```
LEFT JOIN (
    SELECT pay_id, collector_code, start_date, end_date,
        ROW_NUMBER() OVER(PARTITION BY pay_id ORDER BY id DESC)as row_num
    FROM {$dbprefix}asaleh_payment_log
)AS pl ON(pl.pay_id = ap.id AND pl.row_num = '1')
/**
 * ROW_NUMBER() provide sequence number
 * `PARTITION BY` same like `GROUP BY`
 */
```

### session variable
```
SET @rn = 0;
UPDATE 
    table
SET 
    count = @rn := @rn + 1
WHERE 
    count >= 5369
ORDER BY id ASC
```

### update with join
```
UPDATE
    table1 t1
JOIN(
    SELECT 
        team_code,
        MAX(team_name)as team_name
    FROM
        table2
    GROUP BY team_code
)as t2 ON(t2.team_code = t1.team_code)
SET t1.description = t2.team_name
```

### format a date
```
SELECT DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s %p')as formatted_date
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
- block comment                                     `<alt + shift + a>`
- workbench.explorer.fileView.focus                 `<alt + e + e>`
- workbench.files.action.collapseExplorerFolders    `<f>`                   # filesExplorerFocus && !inputFocus
- workbench.files.action.refreshFilesExplorer       `<z>`                   # explorerViewletFocus && !inputFocus
- renameFile                                        `<r>`
- deleteFile                                        `<d>`
- filesExplorer.copy                                `<y>`                   # filesExplorerFocus && foldersViewVisible && !explorerResourceIsRoot && !inputFocus && !notebookEditorFocused
- filesExplorer.cut                                 `<x>`
- filesExplorer.paste                               `<p>`
- list.toggleSelection                              `<v>`
- explorer.openAndPassFocus                         `<l>`
- list.find                                         `<ctrl + f>`
- list.toggleFilterOnType                           `<alt + i>`             # listFocus
- workbench.files.action.focusFilesExplorer         `<ctrl + j>`            # listFocus && filesExplorerFocus
- openInIntegratedTerminal                                                  # ?
- filesExplorer.findInFolder                        `<alt + e + f>`         # ?
- workbench.action.findInFiles                      `<alt + e + />`
- search.focus.nextInputBox                         `<ctrl + j>`
- search.action.collapseSearchResults               `<f>`                   # hasSearchResult && searchViewletFocus && !searchInputBoxFocus
- workbench.action.splitEditor                      `<ctrl + \>`
- workbench.action.toggleEditorWidths               `<ctrl + shift + \>`    # editorFocus
- workbench.action.toggleMaximizedPanel             `<ctrl + shift + \>`    # panelFocus
- workbench.action.terminal.kill                    `<ctrl + w>`            # terminalFocus && terminalCount > 1
- workbench.action.focusPreviousGroup               `<leader + w + h>`
- workbench.action.focusNextGroup                   `<leader + w + l>`
- workbench.action.moveEditorToPreviousGroup        `<leader + w + H>` 
- workbench.action.moveEditorToNextGroup            `<leader + w + L>` 
- scrollLeft                                        `<ctrl + h>`            # vim.active
- scrollRight                                       `<ctrl + l>`            # vim.active
- editor.action.inlineSuggest.hide                  `<ctrl + h>`            # inlineSuggestionVisible
- editor.action.inlineSuggest.acceptNextWord        `<ctrl + l>`            # inlineSuggestionVisible && !editorReadonly
- editor.emmet.action.balanceIn                     `<alt + i>`
- editor.emmet.action.balanceOut                    `<alt + o>`
- editor.emmet.action.wrapWithAbbreviation          `<alt + u>`
- editor.emmet.action.removeTag                     `<alt + backspace>`
- editor.action.addSelectionToNextFindMatch         `<ctrl + n>`            # editorFocus
- editor.action.moveSelectionToPreviousFindMatch    `<ctrl + shift + n>`    # editorFocus
- editor.action.addSelectionToPreviousFindMatch     `<ctrl + p>`            # editorFocus
- visual mode paste without override                                        # NonRecursive
- window.customMenuBarAltFocus                      `false`                 # In settings