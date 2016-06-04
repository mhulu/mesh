import * as utils from '../utils'
import api from '../api'

export const fullscreen = ({ dispatch }) => {
  dispatch('TOGGLE_FULLSCREEN')
  utils.fullscreen()
}

/**
 * 获取用户信息(包括菜单 消息等)
 */
export const getUserInfo = ({ dispatch}, id, update=false) => {
    if (window.sessionStorage.getItem('wemesh.userInfo') === null || update===true) {
        api.getUserInfo(id).then(response => {
            let json = response.data
            window.sessionStorage.setItem('wemesh.userInfo', JSON.stringify(json))
            dispatch('GET_USER_INFO', id, {
                userInfo: json
            })
            window.location.href = '../home/'
        })
        } else {
            let json = JSON.parse(window.sessionStorage.getItem('wemesh.userInfo'))
            dispatch('GET_USER_INFO', {
                userInfo: json
            })
        }
}

/*
更新用户信息(包括菜单 消息等)
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

/**
 * 获取公众号信息
 */
export const getWxmpList = ({ dispatch }) => {
    if (window.sessionStorage.getItem('wemesh.wxmpList') === null) {
            api.getWxmpList().then(response => {
                let json = response.data
                window.sessionStorage.setItem('wemesh.wxmpList', JSON.stringify(json))
                dispatch('GET_WXMP_LIST', {
                    wxmpList: json
                })
            })
        } else {
            let json = JSON.parse(window.sessionStorage.getItem('wemesh.wxmpList'))
            dispatch('GET_WXMP_LIST', {
                wxmpList: json
            })
        }
}

/*
更新公众号信息  TODO!!!!!!!!!
 */
export const updateWxmpList = ({dispatch}) => {
        api.getWxmpList().then(response => {
            var data = response.data
            dispatch('UPDATE_WXMP_LIST', {
                wxmpList: data
            })
        })
      window.location.reload()
}