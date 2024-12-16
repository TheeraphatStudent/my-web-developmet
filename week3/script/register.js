function onSubmittedForm(event, type) {
    event.preventDefault();

    console.log(event);
    console.log(event?.target);

    const form = new FormData(event.target);

    const account = sessionStorage.getItem('meow_account');

    const username = form.get('username') ?? account?.username;
    const password = form.get('password') ?? account?.password;
    const profileImg = form.get('profile_img') ?? account?.profileImg
    const telno = form.get('telno') ?? account?.telno ?? 'undefined';
    const birthday = form.get('birthday') ?? account?.birthday ?? '2000-01-01';
    const gender = form.get('gender') ?? account?.gender ??  'none';

    console.log(`${username} | ${password}`);
    console.log(`${profileImg?.name} | ${telno} | ${birthday}`);

    const expireDate = 60 * 60;

    const reader = new FileReader();

    reader.onload = function (e) {
        const base64Image = e.target.result;

        sessionStorage.setItem('meow_account', JSON.stringify({
            profileImg: base64Image || 'https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-1880.jpg?t=st=1734321722~exp=1734325322~hmac=b0c78807832a186943e4b904c0923b6e8f43e7b4e8b4cd9befe316447c31a5a6&w=826',
            gender,
            telno,
            birthday,
            userId: `meow_${new Date().getTime()}`,
            username,
            password,
            expireDate: new Date().getTime() + expireDate,
        }));

    };

    if (profileImg && profileImg.size > 0) {
        reader.readAsDataURL(profileImg);
    } else {
        sessionStorage.setItem('meow_account', JSON.stringify({
            profileImg: 'https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-1880.jpg?t=st=1734321722~exp=1734325322~hmac=b0c78807832a186943e4b904c0923b6e8f43e7b4e8b4cd9befe316447c31a5a6&w=826',
            gender,
            telno,
            birthday,
            userId: `meow_${new Date().getTime()}`,
            username,
            password,
            expireDate: new Date().getTime() + expireDate,
        }));

        console.log('Default profile image set.');
    }

    
    window.location.href = type == 'edit' ? '../user/view.html' : '../../index.html';
}
