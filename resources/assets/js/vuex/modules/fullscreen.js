const state = {
  isfullscreen: false
}

const mutations = {
  TOGGLE_FULLSCREEN (state) {
    state.isfullscreen = !state.isfullscreen
  }
}

export default ({
  state,
  mutations
})
