let getters = {
    apiUrl: state => {
        return state.apiUrl;
    },
    errors: state => {
        return state.errors
    },
    todos: state => {
        return state.todos
    },
    newTodo: state => {
        return state.newTodo
    },
    updatedTodo: state => {
        return state.updatedTodo
    },
    completedTodos: state => {
        return state.todos.filter(todo => todo.completed);
    }
};
export default getters
