<style>
.wzrk-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border: 1px solid #ddd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 16px;
    width: 300px;
    border-radius: 8px;
    z-index: 9999;
    display: none;
}
.wzrk-alert-heading {
    font-weight: bold;
    margin-bottom: 8px;
    font-size: 16px;
}
.wzrk-alert-body {
    font-size: 14px;
    margin-bottom: 12px;
}
.wzrk-button-container {
    display: flex;
    justify-content: space-between;
}
.wzrk-button-container button {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#wzrk-cancel {
    background: #ccc;
    color: #333;
}
#wzrk-confirm {
    background: #f28046;
    color: white;
}
</style>

<div class="wzrk-alert wiz-show-animate" id="loginPrompt">
    <div class="wzrk-alert-heading">Login Required</div>
    <div class="wzrk-alert-body">Please sign in to continue using your account and access more features.</div>
    <div class="wzrk-button-container">
        <button id="wzrk-cancel">Maybe later</button>
        <button id="wzrk-confirm" onclick="window.location.href='{{ route('logincustomer') }}'">Login Now</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        if (!localStorage.getItem('loginPromptDismissed')) {
            document.getElementById('loginPrompt').style.display = 'block';
        }
    }, 3000);

    document.getElementById('wzrk-cancel').addEventListener('click', function () {
        document.getElementById('loginPrompt').style.display = 'none';
        localStorage.setItem('loginPromptDismissed', 'true');
    });
});
</script>
