
const state = {
  items: []
}

const mutations = {
  ['GET_MENU_LIST'](state, action){
    state.items = action.menuList
  },
  ['UPDATE_MENU_LIST'](state, action){
    state.items = action.menuList
  },
}
export default ({
  state,
  mutations
})
