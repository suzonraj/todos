<template>
    <section id="todos">
        <div class="row mx-0">
            <div class="col-lg-12 px-0">
                <div class="logo text-center">
                    <h1>todos</h1>
                </div>
            </div>
            <div class="col-6 col-xs-12 m-auto">
                <div class="main-div">

                    <div class="row mb-2">
                        <div class="col-1 pr-0">
                            <span><i class="arrow down"></i></span>
                        </div>
                        <div class="col-11 pl-0">
                            <input type="text" v-model="newTodo.todo" @keyup.enter.prevent="addNewTodo"
                                   class="w-100 no-border todo-input" placeholder="Whats need to be done?"/>
                        </div>
                    </div>

                    <hr class="m-0 separator">
                    <div v-if="filterTodos && filterTodos.length" class="mt-2">
                        <div class="todo-list clearfix" v-for="(todo, index) of filterTodos" :key="todo.id">
                            <div @mouseenter="currentTodo = index"
                                 @mouseleave="currentTodo = null">

                                <div class="icheck-success d-inline">
                                    <input v-show="filterTodos.actions" type="radio" :id="'todo'+todo.id"
                                           @click="completeTodo(todo.id)" :checked="todo.completed"/>
                                    <label :for="'todo'+todo.id"></label>
                                </div>

                                <input
                                    v-if="todo.update && !todo.completed"
                                    v-model="todo.todo"
                                    @blur="todo.update = false; updateTodo(todo)"
                                    @keyup.enter="todo.update=false; updateTodo(todo)"
                                    v-focus/>

                                <label v-else @click="todo.update = true"
                                       :class="todo.completed ? 'completed' : '' ">
                                    {{todo.todo}}
                                </label>

                                <a v-show="currentTodo === index" href="" class="float-right cancel"
                                   @click.prevent="deleteTodo(todo)">x</a>
                            </div>
                        </div>

                    </div>

                    <hr class="m-0 separator">
                    <div class="row links" v-if="filterTodos.length || filterBy === 'complete'">
                        <div class="col-3">
                            <a href="#"> <span>{{ filterTodos.length }}</span> {{ (filterTodos.length > 1) ? 'items' :
                                'item' }} left</a>
                        </div>
                        <div class="col-9">
                            <a href="" @click.prevent="filterBy = 'all'" :class="filterBy === 'all' ? 'active' : '' ">All</a>
                            <a href="" @click.prevent="filterBy = 'active'"
                               :class="filterBy === 'active' ? 'active' : '' ">Active</a>
                            <a href="#" @click.prevent="filterBy = 'complete'"
                               :class="filterBy === 'complete' ? 'active' : '' ">Completed</a>
                            <a href="#" @click.prevent="clearCompleted()" v-show="completedTodosCount > 0">Clear
                                Completed</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        mounted() {

        },
        created() {
            this.$store.dispatch("GET_TODOS");
        },
        data: function () {
            return {
                filterBy: 'all',
                currentTodo : null,
            }
        },
        methods: {
            addNewTodo: function () {
                this.$store.dispatch("ADD_TODO");
            },
            updateTodo: function (todo) {
                this.$store.dispatch("UPDATE_TODO", todo);
            },
            deleteTodo: function (todo) {
                this.$store.dispatch("DELETE_TODO", todo);
            },
            completeTodo: function (id) {
                this.$store.dispatch("COMPLETE_TODO", id);
            },
            clearCompleted: function () {
                this.$store.dispatch("CLEAR_COMPLETE_TODO");
            },
        },
        computed: {
            ...mapGetters(["newTodo"]),
            errors() {
                return this.$store.getters.errors
            },

            filterTodos: function () {
                if (this.filterBy === 'all') {
                    return this.$store.getters.todos
                }

                if (this.filterBy === 'active') {
                    return this.$store.getters.todos.filter(todo => todo.completed === false);
                }

                if (this.filterBy === 'complete') {
                    return this.$store.getters.todos.filter(todo => todo.completed);
                }

                // return this.todos.filter(t => {
                //     return this.status === 'active' ? t.completed = false : t.completed = true;
                // })
            },
            completedTodosCount: function () {
                return this.$store.getters.completedTodosCount
            }
        },
        directives: {
            focus: {
                inserted(el) {
                    el.focus()
                }
            }
        }
    }
</script>
