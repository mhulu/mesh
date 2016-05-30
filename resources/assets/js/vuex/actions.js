import * as utils from '../utils'
import api from '../api'

export const fullscreen = ({ dispatch }) => {
  dispatch('TOGGLE_FULLSCREEN')
  utils.fullscreen()
}

/**
 * 获取用户信息
 */
export const getUserInfo = ({ dispatch }) => {
    if (window.sessionStorage.getItem('wemesh.userInfo') === null) {
            api.getUserInfo().then(response => {
                let json = response.data.data
                window.sessionStorage.setItem('wemesh.userInfo', JSON.stringify(json))
                dispatch('GET_USER_INFO', {
                    userInfo: json
                })
            })
        } else {
            let json = JSON.parse(window.sessionStorage.getItem('wemesh.userInfo'))
            dispatch('GET_USER_INFO', {
                userInfo: json
            })
        }
}

/*
更新用户信息
 */
export const updateUserInfo = ({dispatch}) => {
        api.UserInfoResouce().then(response => {
            let json = response.data.data
            window.sessionStorage.setItem('wemesh.userInfo', JSON.stringify(json))
            dispatch('UPDATE_USER_INFO', {
                userInfo: json
            })
        })
      window.location.reload()
}
