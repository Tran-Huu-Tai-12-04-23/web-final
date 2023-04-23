const ruleFunction = {
    email: (name, val, data) => {
        const check = String(val)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
        return check
            ? { code: true, mes: "" }
            : { code: false, mes: "Invalid email address" };
    },
    phone: (name, val, data) => {
        let re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
        return re.test(val)
            ? {
                  code: true,
                  mes: "",
              }
            : {
                  code: false,
                  mes: "Invalid phone number",
              };
    },
    min: (name, val, data) => {
        return val.length >= parseInt(data)
            ? {
                  code: true,
                  mes: "",
              }
            : {
                  code: false,
                  mes: "Min length " + name + " is " + data,
              };
    },
    pass: (name, val, data) => {
        let valuePass = $(".required-pass")[0].value;
        let valueConfirmPassword = $(".required-pass")[1].value;
        if (valueConfirmPassword === "" && name == "password") {
            return {
                code: true,
                mes: "",
            };
        }
        if (name === "password") {
            data = valueConfirmPassword;
        } else {
            data = valuePass;
        }
        return val === data
            ? {
                  code: true,
                  mes: "",
              }
            : {
                  code: false,
                  mes:
                      name === "password"
                          ? name + " not match with confirm password"
                          : name + " not match with password",
              };
    },
    required: (name, val, data) => {
        return val !== "" && val
            ? {
                  code: true,
                  mes: "",
              }
            : {
                  code: false,
                  mes: name + " is not empty!!",
              };
    },
};

function checkErr(rule, item) {
    let nameRule = rule.name;
    let data = "";
    data = rule.data;
    let name = removeUnderscore(item.attr("name"));
    let val = item.val();
    let message = ruleFunction[nameRule](name, val, data);
    return message;
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function handleValidate(rules, item) {
    for (let rule of rules) {
        let message = checkErr(rule, item);
        let notification;
        let parentInput = getParent("input-text", item);
        parentInput.children(".validate").remove();
        if (message.code === false) {
            notification = `<div class='fs-12 validate cl-second'style='color:#E21818'>${capitalizeFirstLetter(
                message.mes
            )}</d>`;
            parentInput.append(notification);
            return false;
        } else {
            notification = `<div class='fs-12 validate cl-second'style='color:#5D9C59'>Correctly!!</d>`;
            parentInput.append(notification);
        }
    }
}
function removeUnderscore(str) {
    return str.replace(/_/g, "");
}
function getRule(item) {
    let rules = item.attr("rule").split("-");
    let resRule = [];
    for (let rule of rules) {
        if (rule.includes(":")) {
            resRule.push({
                name: rule.split(":")[0],
                data: rule.split(":")[1],
            });
        } else {
            resRule.push({ name: rule, data: null });
        }
    }
    return resRule;
}
function validation(form) {
    let formValidate = $(form);
    let listInputHasRule = formValidate.find("input");
    listInputHasRule.blur(function () {
        let rules = getRule($(this));
        handleValidate(rules, $(this));
    });
    let buttonSubmit = getChildren("submit", formValidate);
    buttonSubmit.click(function (e) {
        listInputHasRule = formValidate.find("input");
        for (let input of listInputHasRule) {
            let rules = getRule($(input));
            if (handleValidate(rules, $(input)) === false) {
                e.preventDefault();
            }
        }
    });
}
