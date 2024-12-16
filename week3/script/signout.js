const onSignout = () => {
    console.log('Signout work!');

    sessionStorage.removeItem('meow_account');
    window.location.href = '../../';


}