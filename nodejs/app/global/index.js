const fs = require('fs')
const Axios = require('axios')
const {
  Builder,
  Browser,
  By,
  Key,
  until,
  Capabilities,
} = require('selenium-webdriver')
const { Options } = require('selenium-webdriver/chrome.js')
const { resolve } = require('path')

var driver
function delay(time) {
  return new Promise((resolve) => setTimeout(resolve, time))
}

const loginBuyma = async (id, pwd) => {
  try {
    const options = new Options()
    options.addArguments('--disable-dev-shm-usage')
    options.addArguments('--no-sandbox')
    options.addArguments('--headless')

    driver = await new Builder()
      .forBrowser(Browser.CHROME)
      .setChromeOptions(options)
      .build()

    await driver.get('https://www.buyma.com/login')
    await driver
      .findElement(By.id('txtLoginId'))
      .sendKeys(id, Key.RETURN)
    await driver
      .findElement(By.id('txtLoginPass'))
      .sendKeys(pwd, Key.RETURN)
    await delay(1000)
    let element = await driver.findElement(By.id('login_do'))
    console.log('login element', element)
    await driver.executeScript('arguments[0].click();', element)
    await driver.wait(
      until.elementLocated(By.className('my-page-profile')),
      120000,
    )
    console.log('---logged in---')
  } catch (err) {
    console.log('login buyma error: ', err)
  }
}

const exhibitBuyma = async (product, isAlert, exhibitsettings) => {
  try {
    const {
      product_name,
      product_local_img,
      product_price,
      product_comment,
      bd,
    } = product
    await driver.get('https://www.buyma.com/my/sell/new?tab=b')

    if (isAlert) {
      await driver.wait(until.alertIsPresent())
      await driver.switchTo().alert().accept()
    }

    let img_field = await driver.findElement(
      By.css('.bmm-c-img-upload__box.bmm-c-img-upload__box--empty input'),
    )
    await driver.executeScript(
      "arguments[0].style.display = 'block';",
      img_field,
    )
    const absolute_dirname = resolve('./images')
    const arr = absolute_dirname.split('/')
    await img_field.sendKeys(
      arr.splice(0, arr.length - 1).join('/') + '/' + product_local_img,
    )
    let text_fields = await driver.findElements(
      By.className('bmm-c-text-field'),
    )
    await text_fields[0].sendKeys(bd.name + '-' + product_name, Key.RETURN) // set name of product

    let area_fields = await driver.findElements(By.className('bmm-c-textarea'))
      
    await area_fields[0].sendKeys(
      hankana2Zenkana(product_comment) + '\n' + exhibitsettings.comment,
      Key.RETURN,
    ) // set description of proudct
    let select_controls = await driver.findElements(
      By.className('Select-control'),
    )

    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      select_controls[0],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("click", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      select_controls[0],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mouseup", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      select_controls[0],
    )

    await driver.wait(
      until.elementLocated(By.css('.Select-menu-outer div:nth-child(2)')),
      120000,
    )
    let first_menu_items = await driver.findElements(
      By.css('.Select-menu-outer div'),
    )

    for (let i = 0; i < first_menu_items.length; i++) {
      let text = await first_menu_items[i].getAttribute('class')
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      first_menu_items[3],
    )

     let category_select_controls = []
    while(1) {
        category_select_controls = await driver.findElements(
          By.css('.bmm-l-col.bmm-l-col-4.sell-category__item .Select-control'),
        )
console.log(category_select_controls.length)
        if (category_select_controls.length >=2) break;
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[1],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("click", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[1],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mouseup", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[1],
    )

await driver.wait(
      until.elementLocated(By.css('.Select-menu-outer div:nth-child(2)')),
      120000,
    )
    first_menu_items = await driver.findElements(
      By.css('.Select-menu-outer div'),
    )

    for (let i = 0; i < first_menu_items.length; i++) {
      let text = await first_menu_items[i].getAttribute('class')
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      first_menu_items[3],
    )


    
while(1) {
        category_select_controls = await driver.findElements(
          By.css('.bmm-l-col.bmm-l-col-4.sell-category__item .Select-control'),
        )
        if (category_select_controls.length >=3) break;
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[2],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("click", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[2],
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mouseup", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      category_select_controls[2],
    )

await driver.wait(
      until.elementLocated(By.css('.Select-menu-outer div:nth-child(2)')),
      120000,
    )
    first_menu_items = await driver.findElements(
      By.css('.Select-menu-outer div'),
    )

    for (let i = 0; i < first_menu_items.length; i++) {
      let text = await first_menu_items[i].getAttribute('class')
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      first_menu_items[3],
    )


    let brand_input = await driver.findElement(
      By.css(
        '.bmm-c-custom-text.bmm-c-custom-text--icon-left .bmm-c-text-field',
      ),
    )
    await brand_input.sendKeys(bd.name, Key.RETURN)
    try {
      await driver.wait(
        until.elementsLocated(By.css('.bmm-c-suggest__content div')),
        2000,
      )
      let suggest_content_first_div = await driver.findElement(
        By.css('.bmm-c-suggest__content div'),
      )
      await driver.executeScript(
        'arguments[0].click();',
        suggest_content_first_div,
      )
    } catch (err) {
      let checkboxs = await driver.findElements(By.className('bmm-c-checkbox'))
      await driver.executeScript('arguments[0].click();', checkboxs[0])
    }

    let react_tabs_2 = await driver.findElement(By.id('react-tabs-2'))
    await driver.executeScript('arguments[0].click();', react_tabs_2)
    await driver.wait(
      until.elementLocated(By.css('#react-tabs-3 .Select-control')),
      1000,
    )
    let size_variant_select_control = await driver.findElement(
      By.css('#react-tabs-3 .Select-control'),
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      size_variant_select_control,
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("click", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      size_variant_select_control,
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mouseup", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      size_variant_select_control,
    )

    await driver.wait(
      until.elementsLocated(
        By.css('#react-tabs-3 .Select-menu-outer div'),
        1000,
      ),
    )

    let outer_divs = await driver.findElements(
      By.css('#react-tabs-3 .Select-menu-outer div'),
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      outer_divs[1],
    )

    let sell_amount_div = await driver.findElement(
      By.css('.sell-amount-input input'),
    )
    await sell_amount_div.sendKeys('2', Key.RETURN)

    let panels = await driver.findElements(By.css('form .bmm-c-panel'))
    let deliver_methods = await panels[4].findElements(By.css('table tr'))

    await driver.executeScript('arguments[0].click();', deliver_methods[1])

    let price_input = await panels[6].findElement(
      By.css('.bmm-c-text-field.bmm-c-text-field--half-size-char'),
    )

    await price_input.sendKeys(
      parseInt((product_price * (exhibitsettings.commission + 100)) / 100),
      Key.RETURN,
    )

    let confirm_btn = await driver.findElement(
      By.css('.bmm-c-btn.bmm-c-btn--sec.bmm-c-btn--m.bmm-c-btn--thick'),
    )

    await confirm_btn.click()
    return true
  } catch (err) {
    console.log('exhibit buyma error: ', err)
    return false
  }
}


const getProductsFromBalenciaga = async (url) => {
  let products = []

  const options = new Options()
  options.addArguments('--disable-dev-shm-usage')
  options.addArguments('--no-sandbox')
  options.addArguments('--headless')

  driver = await new Builder()
    .forBrowser(Browser.CHROME)
    .setChromeOptions(options)
    .build()
  await driver.get(url)
  let product_items = await driver.findElements(
    By.className('l-productgrid__item '),
  )
  for (let i = 0; i < product_items.length; i++) {
    let item = product_items[i]
    let product_infos = JSON.parse(
      await (await item.findElement(By.css('article'))).getAttribute(
        'data-gtmproduct',
      ),
    )
    product_infos.image = await (
      await item.findElement(By.className('c-product__image '))
    ).getAttribute('src')

    products.push(product_infos)
  }

  return products
}


const getProductsFromGivenchy = async (url) => {
  let products = []

  const options = new Options()
  options.addArguments('--disable-dev-shm-usage')
  options.addArguments('--no-sandbox')
  options.addArguments('--headless')

  driver = await new Builder()
    .forBrowser(Browser.CHROME)
    .setChromeOptions(options)
    .build()
  await driver.get(url)

  let product_items = await driver.findElements(By.className('product-tile'))
  for (let i = 0; i < product_items.length; i++) {
    let product = {}
    let item = product_items[i]
    product.id = await item.getAttribute('data-gtmproductid')
    product.name = await (
      await item.findElement(By.className('product-name'))
    ).getText()

    try {
      let price_meta = await item.findElement(By.css('meta'))
      if (price_meta) {
        product.price = parseInt(await price_meta.getAttribute('content'))
      } else {
        product.price = 0
      }
    } catch (err) {
      product.price = 0
    }

    let imgs = (
      await (await item.findElement(By.css('img'))).getAttribute('data-srcset')
    ).split(', ')

    product.image = imgs[0] // TODO implement multi images
    products.push(product)
  }
  console.log(products)
  return products
}

async function downloadImage(url, filepath) {
  const response = await Axios({
    url: encodeURI(url),
    method: 'GET',
    responseType: 'stream',
  })
  return new Promise((resolve, reject) => {
    response.data
      .pipe(fs.createWriteStream(filepath))
      .on('error', reject)
      .once('close', () => resolve(filepath))
  })
}

function hankana2Zenkana(str) {
  var kanaMap = {
    ｶﾞ: 'ガ',
    ｷﾞ: 'ギ',
    ｸﾞ: 'グ',
    ｹﾞ: 'ゲ',
    ｺﾞ: 'ゴ',
    ｻﾞ: 'ザ',
    ｼﾞ: 'ジ',
    ｽﾞ: 'ズ',
    ｾﾞ: 'ゼ',
    ｿﾞ: 'ゾ',
    ﾀﾞ: 'ダ',
    ﾁﾞ: 'ヂ',
    ﾂﾞ: 'ヅ',
    ﾃﾞ: 'デ',
    ﾄﾞ: 'ド',
    ﾊﾞ: 'バ',
    ﾋﾞ: 'ビ',
    ﾌﾞ: 'ブ',
    ﾍﾞ: 'ベ',
    ﾎﾞ: 'ボ',
    ﾊﾟ: 'パ',
    ﾋﾟ: 'ピ',
    ﾌﾟ: 'プ',
    ﾍﾟ: 'ペ',
    ﾎﾟ: 'ポ',
    ｳﾞ: 'ヴ',
    ﾜﾞ: 'ヷ',
    ｦﾞ: 'ヺ',
    ｱ: 'ア',
    ｲ: 'イ',
    ｳ: 'ウ',
    ｴ: 'エ',
    ｵ: 'オ',
    ｶ: 'カ',
    ｷ: 'キ',
    ｸ: 'ク',
    ｹ: 'ケ',
    ｺ: 'コ',
    ｻ: 'サ',
    ｼ: 'シ',
    ｽ: 'ス',
    ｾ: 'セ',
    ｿ: 'ソ',
    ﾀ: 'タ',
    ﾁ: 'チ',
    ﾂ: 'ツ',
    ﾃ: 'テ',
    ﾄ: 'ト',
    ﾅ: 'ナ',
    ﾆ: 'ニ',
    ﾇ: 'ヌ',
    ﾈ: 'ネ',
    ﾉ: 'ノ',
    ﾊ: 'ハ',
    ﾋ: 'ヒ',
    ﾌ: 'フ',
    ﾍ: 'ヘ',
    ﾎ: 'ホ',
    ﾏ: 'マ',
    ﾐ: 'ミ',
    ﾑ: 'ム',
    ﾒ: 'メ',
    ﾓ: 'モ',
    ﾔ: 'ヤ',
    ﾕ: 'ユ',
    ﾖ: 'ヨ',
    ﾗ: 'ラ',
    ﾘ: 'リ',
    ﾙ: 'ル',
    ﾚ: 'レ',
    ﾛ: 'ロ',
    ﾜ: 'ワ',
    ｦ: 'ヲ',
    ﾝ: 'ン',
    ｧ: 'ァ',
    ｨ: 'ィ',
    ｩ: 'ゥ',
    ｪ: 'ェ',
    ｫ: 'ォ',
    ｯ: 'ッ',
    ｬ: 'ャ',
    ｭ: 'ュ',
    ｮ: 'ョ',
    '｡': '。',
    '､': '、',
    ｰ: 'ー',
    '｢': '「',
    '｣': '」',
    '･': '・',
  }
  var reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g')
  var result
  if (str) {
  result = str
    .replace(reg, function (match) {
      return kanaMap[match]
    })
    .replace(/ﾞ/g, '゛')
    .replace(/ﾟ/g, '゜')
   }
  else {
    result = ''
}

  console.log(result)
  return result
}

module.exports = {
  downloadImage,
  loginBuyma,
  exhibitBuyma,
  getProductsFromBalenciaga,
  getProductsFromGivenchy
}
