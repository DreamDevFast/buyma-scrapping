const { Builder, Browser, By, Key, until } = require('selenium-webdriver')

;(async function example() {
  let driver = await new Builder().forBrowser(Browser.CHROME).build()
  try {
    await driver.get('http://www.buyma.com/login')
    await driver
      .findElement(By.id('txtLoginId'))
      .sendKeys('te87533555@gmail.com', Key.RETURN)
    await driver
      .findElement(By.id('txtLoginPass'))
      .sendKeys('st87533555', Key.RETURN)
    let element = driver.findElement(By.id('login_do'))
    await driver.executeScript('arguments[0].click();', element)

    console.log('---logged in---')

    await driver.wait(
      until.elementLocated(By.className('my-page-profile')),
      120000,
    )
    await driver.get('http://www.buyma.com/my/sell/new?tab=b')

    let text_fields = await driver.findElements(
      By.className('bmm-c-text-field'),
    )
    await text_fields[0].sendKeys('Beautiful Women Sandal---1', Key.RETURN) // set name of product

    let area_fields = await driver.findElements(By.className('bmm-c-textarea'))
    await area_fields[0].sendKeys('This is new arrival from Italy', Key.RETURN) // set description of proudct

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
    let first_menu_item = await driver.findElement(
      By.css('.Select-menu-outer div:nth-child(2)'),
    )
    await driver.executeScript(
      'arguments[0].dispatchEvent(new MouseEvent("mousedown", {view: window,bubbles: true,cancelable: true,buttons: 1}));',
      first_menu_item,
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
    console.log(await outer_divs[1].getAttribute('class'))
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

    await price_input.sendKeys('10000', Key.RETURN)

    let confirm_btn = await driver.findElement(
      By.css('.bmm-c-btn.bmm-c-btn--sec.bmm-c-btn--m.bmm-c-btn--thick'),
    )

    await confirm_btn.click()
  } catch (err) {
    console.log(err)
  } finally {
    // await driver.quit()
  }
})()
