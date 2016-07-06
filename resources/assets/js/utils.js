import screenfull from 'screenfull'

export function fullscreen () {
  if (screenfull.enabled) {
    screenfull.toggle()
  }
}

/**
 * 从对象中取出第一条
 */
export function findFirst(obj) {
  for (var k in obj) {
    if (obj[k].length) {
      return obj[k][0]
    }
  }
}

/**
 * 遍历一个对象,取出指定k-v 的一组
 */
export function selectFromJson(obj, key, value) {
  for (var i = 0; i< obj.length; i++) {
    if (obj[i][key] === value) {
      return obj[i]
    }
  }
}

/**
 * 从当前的url中提取指定部分名称
 * @param 传入的路径,得有/.../这种斜杠喔
 * @param  {int} index [位置,通常0为父级]
 */
export function getPartFromPath(path = location.href, index = 0) {
  var re = /\/\w+/g
  var route = path.match(re)[index]
  return route.split('/').pop()
}

export function hasClass (el, className) {
  return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className)
}

export function addClass (el, className) {
  if (el.classList) el.classList.add(className)
  else if (!hasClass(el, className)) el.className += ' ' + className
}

export function removeClass (el, className) {
  if (el.classList) el.classList.remove(className)
  else el.className = el.className.replace(new RegExp('\\b' + className + '\\b', 'g'), '')
}

export function shake (el) {
  el.classList.add('shake')
  setTimeout(() => {
    el.classList.remove('shake')
  }, 650)
}

export function toggle (el) {
  var display = (window.getComputedStyle ? window.getComputedStyle(el, null) : el.currentStyle).display
  if (display === 'none') {
    el.style.display = 'block'
  } else {
    el.style.display = 'none'
  }
}

export function hasId (el) {
  var element = document.getElementById(el)
  return typeof (element) != 'undefined' &&  element != null
}
/**
 * 在指定元素加上倒计时
 * @param  {[type]} ele      [DOM元素]
 * @param  {[type]} seconds [倒计时的秒数]
 * @return {[type]}        [description]
 */
export function countdown (ele, seconds) {
  var timer
  var originTxt = ele.innerHTML
  timer = setInterval(function () {
    seconds--
    if (seconds < 0) {
      ele.innerHTML = originTxt
      clearInterval(timer)
      ele.disabled = false
    } else {
      ele.innerHTML = '请等' + seconds.toString() + '秒'
      ele.disabled = true
    }
  }, 1000)
}

export function toggleClass (wrapperSelector, targetSelector, className) {
  var target = document.querySelectorAll(wrapperSelector)
  for (var i = 0; i < target.length; i++) {
    target[i].classList.remove(className)
    targetSelector.classList.add(className)
  }
}
