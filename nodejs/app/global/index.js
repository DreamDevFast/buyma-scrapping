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

const loginBuyma = async () => {
  try {
    const options = new Options()
    options.addArguments('--disable-dev-shm-usage')
    options.addArguments('--no-sandbox')
    // options.addArguments('--headless')

    driver = await new Builder()
      .forBrowser(Browser.CHROME)
      .setChromeOptions(options)
      .build()

    await driver.get('http://www.buyma.com/login')
    await driver
      .findElement(By.id('txtLoginId'))
      .sendKeys('te87533555@gmail.com', Key.RETURN)
    await driver
      .findElement(By.id('txtLoginPass'))
      .sendKeys('st87533555', Key.RETURN)
    await delay(1000)
    let element = await driver.findElement(By.id('login_do'))
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

const exhibitBuyma = async (product, isAlert) => {
  try {
    const {
      product_name,
      product_local_img,
      product_price,
      product_comment,
    } = product
    await driver.get('http://www.buyma.com/my/sell/new?tab=b')

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
    const arr = absolute_dirname.split('\\')
    await img_field.sendKeys(
      arr.splice(0, arr.length - 1).join('/') + '/' + product_local_img,
    )
    let text_fields = await driver.findElements(
      By.className('bmm-c-text-field'),
    )
    await text_fields[0].sendKeys(product_name, Key.RETURN) // set name of product

    let area_fields = await driver.findElements(By.className('bmm-c-textarea'))
    await area_fields[0].sendKeys(product_comment, Key.RETURN) // set description of proudct

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

    console.log(first_menu_items.length)
    for (let i = 0; i < first_menu_items.length; i++) {
      let text = await first_menu_items[i].getAttribute('class')
      console.log(text)
    }
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      first_menu_items[3],
    )

    let checkboxs = await driver.findElements(By.className('bmm-c-checkbox'))
    await driver.executeScript('arguments[0].click();', checkboxs[0])

    let react_tabs_2 = await driver.findElement(By.id('react-tabs-2'))
    await driver.executeScript('arguments[0].click();', react_tabs_2)
    await driver.wait(
      until.elementLocated(By.css('#react-tabs-3 .Select-control'), 1000),
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

    let panels = await driver.findElements(By.css('form .bmm-c-panel'))
    let deliver_methods = await panels[4].findElements(By.css('table tr'))
    await driver.executeScript('arguments[0].click();', deliver_methods[5])

    let price_input = await panels[6].findElement(
      By.css('.bmm-c-text-field.bmm-c-text-field--half-size-char'),
    )

    await price_input.sendKeys(product_price, Key.RETURN)

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

async function downloadImage(url, filepath) {
  const response = await Axios({
    url,
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

module.exports = {
  downloadImage,
  loginBuyma,
  exhibitBuyma,
}
