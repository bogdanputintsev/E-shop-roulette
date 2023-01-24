class User
{
    id = null;
    username = null;
    balance = null;
    daily_gift = null;
    GetUserInfo()
    {
        let user = dataUser.GetUserInfo();
        console.info(user);
        this.id = user.id;
        this.username = user.username;
        this.balance = user.balance;
        this.daily_gift = user.daily_gift;
    }
    GetBalance()
    {
        this.balance = dataUser.GetUserBalance();
    }
}