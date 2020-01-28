let actions = {
    GET_TODOS({commit}) {
        axios.get(this.state.apiUrl + '/todos')
            .then(response => {
                let results = response.data.data;

                _.forEach(results, (todo) => {
                    commit('GET_TODOS', {
                        id: todo.id,
                        todo: todo.todo,
                        completed: todo.completed,
                        update: todo.update,
                        actions: false,
                    });
                });
            })
            .catch(e => {
                commit('SET_ERROR', e);
            });
    },
    ADD_TODO({commit}) {

        axios.post(this.state.apiUrl + '/todos', {
            body: this.state.newTodo.todo
        }).then(res => {
            let todo = this.state.newTodo;
            commit('ADD_TODO', {
                id: todo.id,
                todo: todo.todo,
                completed: todo.completed,
                update: todo.update,
                actions: false,
            });

            todo.todo = null;
        }).catch(e => {
            commit('SET_ERROR', e);
        })
    },
    UPDATE_TODO({commit}, todo) {
        axios.patch(this.state.apiUrl + '/todos/' + todo.id, {
            body: todo.todo
        })
            .then(response => {
                commit('UPDATE_TODO', todo)
            })
            .catch(e => {
                commit('SET_ERROR', e);
            });
    },
    DELETE_TODO({commit}, todo) {
        axios.delete(this.state.apiUrl + '/todos/' + todo.id)
            .then(res => {
              commit('DELETE_TODO', todo);
            }).catch(err => {
            commit('SET_ERROR', err);
        })
    },
    COMPLETE_TODO({commit}, id) {
        axios.patch(this.state.apiUrl + '/todos/' + id + '/complete')
            .then(response => {
                commit('COMPLETE_TODO', id);
            })
            .catch(e => {
                commit('SET_ERROR', e);
            });
    },
    CLEAR_COMPLETE_TODO({commit}) {
        axios.post(this.state.apiUrl + '/todos/clear-completed')
            .then(response => {
                commit('CLEAR_COMPLETE_TODO');
            })
            .catch(e => {
                console.log(e);
            })
    }
};
export default actions
