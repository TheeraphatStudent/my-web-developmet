function onSubmittedForm(event, type) {
    event.preventDefault();

    console.log(event);
    console.log(event?.target);

    const form = new FormData(event.target);

    let account = sessionStorage.getItem('meow_account');
    account = account ? JSON.parse(account) : {};

    const username = account.username ?? form.get('username') ?? '-';
    const password = account.password ?? form.get('password') ?? '-';
    const profileImg = account.profileImg ?? form.get('profile_img') ?? '-';
    const telno = account.telno ?? form.get('telno') ?? '-';
    const birthday = account.birthday ?? form.get('birthday') ?? '-';
    const gender = account.gender ?? form.get('gender') ?? '-';

    console.log(`${username} | ${password}`);
    console.log(`${profileImg?.name} | ${telno} | ${birthday}`);

    sessionStorage.removeItem('meow_account');

    const expireDate = 60 * 60;

    const reader = new FileReader();

    reader.onload = function (e) {
        const base64Image = e.target.result;

        sessionStorage.setItem('meow_account', JSON.stringify({
            profileImg: base64Image ?? 'https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-1880.jpg?t=st=1734321722~exp=1734325322~hmac=b0c78807832a186943e4b904c0923b6e8f43e7b4e8b4cd9befe316447c31a5a6&w=826',
            gender,
            telno,
            birthday,
            userId: account.userId ?? `meow_${new Date().getTime()}`,
            username,
            password,
            expireDate: new Date().getTime() + expireDate,
        }));

        redirectToPage(type);
    };

    if (profileImg && profileImg.size > 0) {
        reader.readAsDataURL(profileImg);
    } else {
        sessionStorage.setItem('meow_account', JSON.stringify({
            profileImg: account.profileImg ?? 'https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-1880.jpg?t=st=1734321722~exp=1734325322~hmac=b0c78807832a186943e4b904c0923b6e8f43e7b4e8b4cd9befe316447c31a5a6&w=826',
            gender,
            telno,
            birthday,
            userId: account.userId ?? `meow_${new Date().getTime()}`,
            username,
            password,
            expireDate: new Date().getTime() + expireDate,
        }));

        redirectToPage(type);
    }
}

function redirectToPage(type) {
    window.location.href = type === 'edit' ? '../user/view.html' : '../../index.html';
}

