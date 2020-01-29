let mutations = {
    SET_ERROR(state, error) {
        state.errors.unshift(error);
    },
    GET_TODOS(state, todos) {
        state.todos.push(todos);
    },
    ADD_TODO(state, todo) {
        state.todos.push(todo);
    },
    UPDATE_TODO(state, todo) {
        let t = state.todos.findIndex(o => o.id === todo.id);
        state.todos[t] = todo;
    },
    DELETE_TODO(state, todo) {
        state.todos.splice(state.todos.findIndex(t => t.id === todo.id), 1)
    },
    COMPLETE_TODO(state, id) {
        let t = state.todos.findIndex(o => o.id === id);
        state.todos[t].completed = true;
    },
    CLEAR_COMPLETE_TODO(state) {
        state.todos = state.todos.filter(t => t.complete === false);
    }
};
export default mutations
