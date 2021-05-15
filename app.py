from flask import Flask, request, abort

from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import (
    MessageEvent, TextMessage, TextSendMessage,
)
import requests

app = Flask(__name__)

line_bot_api = LineBotApi('YfOeBa+9PBbMth/nIDbp0ID4QqKGPv4P07s0QO+7JnuFWsBUbPvpoU7grEczAX9Oa5ACNbzuK7w8UMgmUGbOvh9vix+1FtH5YHYJ3GPOuOOtlA3dMKFObgyRXm8wIFP5bXiGcM/cYx3p5JxsFkjWswdB04t89/1O/w1cDnyilFU=')
handler = WebhookHandler('805f41029c7d7db73aade9487647b40b')


@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']

    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)

    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        print("Invalid signature. Please check your channel access token/channel secret.")
        abort(400)

    return 'OK'


@handler.add(MessageEvent, message=TextMessage)
def handle_message(event):
    input_text = str(event.message.text)
    coin_text = input_text.split('換')
    if "換" in input_text:
        resp = requests.get('https://tw.rter.info/capi.php')
        currency_data = resp.json()
        change1 = currency_data["USD"+coin_text[0]]['Exrate']
        change2 = currency_data["USD"+coin_text[1]]['Exrate']
        tmp = change2/change1
        line_bot_api.reply_message(
            event.reply_token,
            TextSendMessage(text="{}換{}=1:{}".format(coin_text[0],coin_text[1],str(tmp))))



if __name__ == "__main__":
    app.run(port=8000)