# VUE & TS

## Single-File Components (SFC)

```
<scirpt setup lang="ts"></scirpt>

<template></template>

<style scope></style>
```
Encapsulates the component's logic(JavaScript), template(HTML), and styles(CSS) in a single file.

---

### Reactivity Fundamentals

`ref()` takes the argument and returns it wrapped within a ref object with a `.value`. (can use in component, middleware, utils, etc)

`reactive()` reactive objects are JavaScript Proxies, vue is able track, access and mutaion of all properties. (can use only inside component)

- `shallowReactive()`

### ref() unwrapping

```
const count = ref(0)
const state = reactive({ count })

console.log(state.count)
```

also would be unwrapped when within a template tag.

### Computed

similar to a method, but it is reactive property and its result is cached. (using with reactive dependency!)

### Bindings (Shorten `:`)

to assign **attributes** a string value dynamically

```
const classObject = reactive({
    active: true,
    'text-danger': false
})

<div v-bind:class="classObject"></div>
```

### Conditional Rendering

`v-if`, `v-else`, `v-else-if`, and `v-show`

> Note: It's not recommended to use `v-if` and `v-for` on the same element.

### List Rendering

`v-for`

```
const items = ref([{ id: 0, message: 'foo', children: [100, 0] }, { id: 1, message: 'bar', children: [200, 0] }])

<li v-for="(item, index) of items" :key="item.id">
    <span v-for="childItem of item.children">
        {{ index }} {{ item.message }} {{childItem}}
    </span>
</li>
```

with an **Object**

```
const someObject = reactive({
    title: '',
    auther: ''
})

<ul>
    <li v-for="(value, key, index) in someObject">
        {{ index }}. {{ key }}: {{ value }}
    </li>
</ul>
```

with a **range**

```
<span v-for="n in 10">{{ n }}</span>
```

### Listening to Events (Shorten `@`)

```
function doSomething(msg, event){
    if(event){ event.preventDefault() }
    alert(msg)
    console.log(event)
}

<button v-on:click="doSomething('hello', $event)">Click me!</button>
```

### Form Input Bindings

`v-model` directive makes it easy to bind data to a form input.

```
const newPriority = ref(false)
<label>
    <input type="checkbox" v-model="newPriority"> Priority {{ newPriority }}
</label>

const newSelect = ref('')
const options = ref([
    { text: 'zero', value: 0 },
    { text: 'one', value: 1 }
])
<div>Selected: {{ newSelect }}</div>
<select v-model="newSelect">
    <option disabled>Please select</option>
    <option v-for="option of options" :value="option.value">{{ option.text }}</option>
</select>
```

> Note: `v-model` Ignore attrbutes on any form elements. Should declare initial value on the JavaScript side.

**TypeScript define**

```
// ref()
type InputRow{
    id: number
    name: string
    age: number
}
const inputRows = ref<InputRow[]>([
    { id: 0, name: '', age: null }
])
inputRows.value.forEach((row) => {
    console.log(JSON.parse(JSON.stringify(row)))
})

// reactive()
interface restrictInputs{
    name: string
    age: number
    lang: 'us' | 'th'
}
const personInput = reactive<restrictInputs>({
    name: '',
    age: 0,
    lang: 'us'
})
// body: JSON.stringify(personInput)
```

### Watchers

to perform side effects.

```
const queue = ref(0)
const user = reactive({ name: 'Bryan', age: 19 })

// use getter function to track dependency
watch([queue, () => user.age], ([newQueue, newAge], [oldQueue, oldAge]) => {
    console.log(`Age: ${oldAge} -> ${newAge}`)
})

queue.value++ // trigger watch()
```

`watchEffect` It automaticlly tracks every reactive property accessed inside the callback.

### Template Refs

to direct access to the underlying DOM elements.

```
// v3.5+
import { useTemplateRef, onMounted } from 'vue'
const input = useTemplateRef('name-input')
onMounted(() => {
    input.value.focus()
})

<input ref="name-input">
```

### Component Basics

Passing Props allows data to be passed from a parent component to a child component.

```
...
<ChildComponent
    v-for="item in items"
    :foo="item.foo"
    :bar="item.bar"
/>
```

```
interface Props {
    foo: string,
    bar?: number[]
}
const props = withDefaults(defineProps<Props>(), {
    foo: 'A',
    bar: () => [0, 1]
})

// const { foo, bar } = toRefs(props) // destructure
// console.log(foo, bar)

const local_foo = ref(props.foo) // define a local data to update the data
```

> Note: Default value with `withDefaults` reference types should be wrapped in function.

, class and constructor function

**Person.ts**

```
export class Person{
    name: string
    age: number
    constructor(name: string, age: number){
        this.name = name
        this.age = age
    }
}
```

**Parent**

```
...
import { Person } from '.Person'
const bryan = new Person('Bryan', 15)

<ChildComponent :author="bryan"/>
```

**Child**

```
...
import { Person } from '.Person'
const props = defineProps<{
    author: Person
}>()

<p>{{ props.author.name }} is {{ props.author.age }} year old.</p>
```

`$emit` method that communicating back up to parent component.

**Parent component** (listener)

```
...
<ChildComponent
    @change="(id: number) => console.log('Change event!', id)"
    @update="(value: string) => console.log('Update event!', value)"
/>
```

**Child component** (declare emit event)

```
// v3.3+
const emit = defineEmits<{
    change: [id: number]
    update: [value: string]
}>()

function handleClick(){
    emit('change', 01)
    emit('update', 'new text')
}

<button @click="handleClick">Trigger events!</button>
```

### Component v-model (v3.4+)

use on a compenent to implement a two-way binding.

Parent

```
const name = ref('Bryan')

<template>
    <h1>{{ name }}</h1>
    <ChildComponent v-model:name="name"/>
</template>
```

Child

```
const name = defineModel('name')
<input type="text" v-model="name"/>
```

### Provide / Inject

to provide data to a component's descendants (tree diagram).

Parent

```
import { provide } from 'vue'
const theme = ref('light')
provide('theme', theme) // provide(key, value)

...
```

GrandChild

```
import { inject } from 'vue'
const theme = inject('theme') // inject(key)

<p>Theme: {{ theme }}</p>
```

provide at the App-level:

```
import { createApp } from 'vue'
const app = createApp({})
app.provide('locale', 'th')
```

### Async Components (Lazy loading)

only load a component from the server it's needed.

```
import { ref, defineAsyncComponent } from 'vue'
const AsyncUserProfile = defineAsyncComponent(() => {
    loader: () => import('./UserProfile.vue'),

    loadingComponent: {
        template: '<p>Loading...</p>'
    },
    errorComponent: ErrorComponent,

    delay: 200,
    timeout: 5000
})
```

### Reusability

Composable is reuse stateful logic. extract the logic into an external file. (should only be data, not for event logic)

```
// useMouseTracker.vue
import { ref, onMounted, onUnmounted } from 'vue'

export function useMouseTracker(){
    const x = ref(0)
    const y = ref(0)

    function update(event){
        x.value = event.pageX
        y.value = event.pageY
    }

    onMounted(() => window.addEvenListener('mousemove', update))
    onUnMounted(() => window.removeEvenListener('mousemove', update))

    return { x, y }
}
```

```
import { useMouseTracker } from '@/composables/useMouseTracker'
const mouse = reactive(useMouseTracker())
console.log(mouse.x, mouse.y)
```

Async state

```
// useFetch.vue
import { ref, watchEffect, toValue } from 'vue'

export function useFetch(url){
    const data = ref(null)
    const error = ref(null)

    const fetchData = () => {
        data.value = null // reset state
        error.value = null

        fetch(toValue(url)) // toValue() v3.3+
            .then((res) => res.json())
            .then((json) => (data.value = json))
            .catch((err) => (error.value = err))
    }

    watchEffect(() => { fetchData() }) // re-fetch whenever the URL changes

    return { data, error }
}
```

### Lifecycle Hooks

`onMounted()` `onUpdated()` `onUnmounted()` `onBeforeMount()` `onBeforeUpdate()` `onBeforeUnmount()`

### Vue Router

`npm install vue-router@4`

```
src/
├─ views
└─ router/index.ts
```

router/index.ts

```
import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'

import HomeView from '../views/HomeView.vue'

const routes: RouteRecordRaw[] = [
  { path: '/home', component: () => HomeView }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
```

main.ts

```
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.ts'

createApp(App).use(router).mount('#app')
```

App.vue

```
...
<RouterLink class="" to="/">Home</RouterLink>
<main>
    <RouterView/>
</main>
```

`useRoute()`

`useRouter()`

### Debug proxy

```
import { watch } from 'vue'
watch(parts, (newItem, oldItem) => {
    console.log(`Loading state changed. Previous: ${oldItem.length}, New: ${newItem.length}`)
    newItem.forEach((item) => {
        console.log(JSON.parse(JSON.stringify(item)))
    })
})
// { deep: true } if ref()
// { immediate: true } perform before state change
```

### Writable Computed Property (Getter/Setter)

```
const newValue = computed({
    get: () => foo.value
    set: (value: number) => {
        if(value < 0){ value = 0}
        foo.value = value
    }
})
```

## TypeSctipt

### Type / Interface

Type

- union (|) / intersection (&)
- type alias of primitive
- type utility
  Interface
- object / class
- extends

### Generic Types

```

```

### Abstract Class
```

```

## Git

### merge main
```
git checkout main
git pull origin main
git merge <refactor_branch>
git add .
git commit -m "merge: refactor structure into main"
```

### Git deploy
```
git add dist -f
git commit -m "adding dist"
git subtree push --prefix dist origin gh-pages
```
