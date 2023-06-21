let TotalQuestions = 0;
let QTypeOptions = [];
QType[0].forEach(element => {
    QTypeOptions.push(`<option value="` + element.QuestionType_id + `">` + element.QuestionType + `</option>`);
});
QTypeOptions = QTypeOptions.join("");

function addNew() {
    let QHolder = document.getElementById('QHolder');
    TotalQuestions++;
    // QHolder.innerHTML

    html_to_insert = `<div id="div` + TotalQuestions + `"><div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="Question`+ TotalQuestions + `">Question:` + TotalQuestions + `</label>
                                <input type="text" maxlength="250" class="form-control" id="Question`+ TotalQuestions + `"
                                    name="Question[`+ TotalQuestions + `]" Placeholder="Type your question here" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label for="Type`+ TotalQuestions + `">Type:</label>
                                <select type="text" maxlength="250" class="form-control" id="Type`+ TotalQuestions + `" name="Type[` + TotalQuestions + `]" required>
                                    <option value="">Please Select</option>`+ QTypeOptions + `</select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Delete Question</label>
                                <button type="button" class="btn btn-outline-danger form-control"
                                    onclick="removeMe(this);" id="` + TotalQuestions + `">X</button>
                            </div>
                        </div>
                        <hr>
                        </div>`;
    QHolder.insertAdjacentHTML('beforeend', html_to_insert);
}

function removeMe(me) {
    let id = me.id;
    document.getElementById("div" + id).remove();
}