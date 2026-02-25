// 获取输入框和按钮元素
var inputBox = document.getElementById("inputBox");
var sendBtn = document.getElementById("sendBtn");

// 获取聊天容器元素
var chatContainer = document.getElementById("chatContainer");

// 监听输入框内容变化事件
inputBox.addEventListener("input", function() {
  // 如果输入框内容为空，设置按钮透明度为70%并禁用点击事件
  if (inputBox.value === "") {
    sendBtn.style.opacity = 0.7;
    sendBtn.disabled = true;
  } else {
    sendBtn.style.opacity = 1;
    sendBtn.disabled = false;
  }
});

// 监听按钮点击事件
sendBtn.addEventListener("click", function() {
  // 输入框非空时执行发送操作
  if (inputBox.value !== "") {
    // 创建用户发送的信息气泡
    createUserBubble(inputBox.value);

    // 模拟自动回复的内容
    var autoReplyContent = getAutoReplyContent(inputBox.value);
    // 创建自动回复的信息气泡
    createAutoReplyBubble(autoReplyContent);

    // 清空输入框内容
    inputBox.value = "";
    // 重置按钮透明度和禁用状态
    sendBtn.style.opacity = 0.7;
    sendBtn.disabled = true;

    // 滚动到最底部
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }
});

// 创建用户发送的信息气泡
function createUserBubble(content) {
  var userBubble = document.createElement("div");
  userBubble.classList.add("bubble-container", "clearfix");
  userBubble.innerHTML =
    `<div class="user-bubble">
      ${content}
      <img class="avatar" src="http://q2.qlogo.cn/headimg_dl?dst_uin=1778798003&spec=640">
    </div>`;
  chatContainer.appendChild(userBubble);
}

// 创建自动回复的信息气泡
function createAutoReplyBubble(content) {
  var autoReplyBubble = document.createElement("div");
  autoReplyBubble.classList.add("bubble-container", "clearfix");
  autoReplyBubble.innerHTML =
    `<div class="auto-reply-bubble">
      <img class="avatar" src="http://q2.qlogo.cn/headimg_dl?dst_uin=3373491752&spec=640">
      ${content}
    </div>`;
  chatContainer.appendChild(autoReplyBubble);
}

// 定义模糊回复的选项
const fuzzyReplies = [
  { keywords: ["你好", "您好", "hello", "Hello", "Hi", "hi"], reply: "你好！请问有什么需要帮助的吗？" },
  { keywords: ["你是谁", "你是？"], reply: "我是一个由  小执科技  开发的在线AI客服，可以回答你的问题哦！" },
  { keywords: ["谢谢", "感谢"], reply: "不客气，有问题随时问哈！" },
  { keywords: ["可以帮助", "怎么问", "如何咨询"], reply: "你可以问关于技术、学习、生活等方面的问题。" },
  // 添加更多模糊回复选项
];

// 根据用户发送的内容获取自动回复的内容
function getAutoReplyContent(userContent) {
  // 遍历模糊回复选项，寻找匹配的关键词
  for (const replyOption of fuzzyReplies) {
    if (replyOption.keywords.some(keyword => userContent.includes(keyword))) {
      return replyOption.reply;
    }
  }

  // 如果没有匹配的关键词，返回默认回复
  return "抱歉，我不太理解你的问题，可以换个方式问吗？";
}