<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo Component</div>

                    <div class="card-body">
                        <input type="text" v-model="newTodo" @keyup.enter="addNewTodo"/>

                        <div v-if="filterTodo && filterTodo.length">
                            <div class="form-group clearfix" v-for="todo of filterTodo" :key="todo.id">
                                <div class="icheck-success d-inline">
                                    <input type="radio" :id="'todo'+todo.id" @click="completeTodo(todo.id)"/>
                                    <label :for="'todo'+todo.id" :class="todo.completed ? 'completed' : '' ">
                                        {{todo.todo}}
                                    </label>
                                </div>

                                <a href="" class="text-right" @click.prevent="deleteTodo(todo.id)">x</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" v-if="filterTodo.length">
                        <div class="row">
                            <div class="col-4">
                                <span>{{ filterTodo.length }}</span> {{ (filterTodo.length > 1) ? 'items' : 'item' }} left
                            </div>
                            <div class="col-2">
                                <a href="" @click.prevent="status = 'all'">All</a>
                            </div>
                            <div class="col-2">
                                <a href="" @click.prevent="status='active'">Active</a>
                            </div>
                            <div class="col-2">
                                <a href="#" @click.prevent="status='complete'">Completed</a>
                            </div>
                            <div class="col-2">
                                <a href="#" @click.prevent="clearCompleted">Clear Completed</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            route: {type: String, required: true}
        },
        mounted() {
            //console.log('Component mounted.')
        },
        // Fetches todos when the component is created.
        created() {
            axios.get(this.route + '/todos')
                .then(response => {
                    this.todos = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        },
        data: function () {
            return {
                newTodo: '',
                status: 'all',
                todos: [],
                errors: [],
            }
        },
        methods: {
            addNewTodo() {
                axios.post(this.route + '/todos', {
                    body: this.newTodo
                })
                    .then(response => {
                        this.todos.push(response.data);
                        this.newTodo = '';
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            completeTodo(id) {
                axios.patch(this.route + '/todo/' + id + '/complete')
                    .then(response => {
                        const currentIndex = this.todos.findIndex(o => o.id === id);

                        let todo = _.find(this.todos, function (o) {
                            return o.id === id;
                        });
                        todo.completed = true;

                        this.todos[currentIndex] = todo;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            deleteTodo(id) {
                axios.delete(this.route + '/todos/' + id)
                    .then(response => {
                        const currentIndex = this.todos.findIndex(t => t.id === id);
                        this.$delete(this.todos, currentIndex);
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            clearCompleted() {
                // _.filter(users, function(o) { return !o.active; });
            }
        },
        computed: {
            filterTodo: function () {
                if (this.status === 'all'){
                    return this.todos;
                }

                if (this.status === 'active'){
                    return this.todos.filter(t => {
                        return t.completed === false;
                    })
                }

                if (this.status === 'complete'){
                    return this.todos.filter(t => {
                        return t.completed === true;
                    })
                }

                // return this.todos.filter(t => {
                //     return this.status === 'active' ? t.completed = false : t.completed = true;
                // })
            }
        },
        // watch: {
        //     new_task: {
        //         immediate: true,
        //         handler() {
        //             this.addNewTask();
        //         }
        //     }
        // }
    }
</script>
