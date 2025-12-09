
// Handle Collapses

let profileCollapse, subCollapse = false
const profile = document.getElementById('profile-id')
const sub = document.getElementById('sub-id')
const blurscreen = document.getElementById('blur')


function handleCollapses(){
    if (innerWidth > 1000){
        profile.style.display = 'flex'; profile.style.position = 'relative'
        profile.style.transform = 'translate(0px)'
        profile.style.zIndex = '0'
        document.getElementById('profile-collapse').disabled = true
        profileCollapse = false

    } else {
        profile.style.display = profileCollapse ? 'flex' : 'none'
        document.getElementById('profile-collapse').style.backgroundColor = '#EE4E4E'
        document.getElementById('profile-collapse').disabled = false
    }
    
    if (innerWidth > 800){
        sub.style.display = 'flex'; sub.style.position = 'relative'
        sub.style.transform = 'translate(0px)'
        sub.style.zIndex = '0'
        document.getElementById('sub-collapse').disabled = true
        subCollapse = false

    } else {
        sub.style.display = subCollapse ? 'flex' : 'none'
        document.getElementById('sub-collapse').style.backgroundColor = '#EE4E4E'
        document.getElementById('sub-collapse').disabled = false
    }
}

window.onload = () => handleCollapses()
window.addEventListener('resize', handleCollapses)

function handleProfileCollapse(){

    subCollapse ? handleSubCollapse() : ''

    profileCollapse = !profileCollapse
    profile.style.display = profileCollapse ? 'flex' : 'none'
    document.getElementById('profile-collapse').style.backgroundColor = profileCollapse ? '#A1C398' : '#EE4E4E'
    blurscreen.style.backdropFilter = profileCollapse ? 'blur(10px)' : 'blur(0px)'
    profile.style.position = 'absolute'
    profile.style.transform = 'translate(70px)'
    profile.style.zIndex = '2'
}

function handleSubCollapse(){

    profileCollapse ? handleProfileCollapse() : ''

    subCollapse = !subCollapse
    sub.style.display = subCollapse ? 'flex' : 'none'
    document.getElementById('sub-collapse').style.backgroundColor = subCollapse ? '#A1C398' : '#EE4E4E'
    blurscreen.style.backdropFilter = subCollapse ? 'blur(10px)' : 'blur(0px)'
    sub.style.position = 'absolute'
    sub.style.transform = 'translate(70px)'
    sub.style.zIndex = '2'
}