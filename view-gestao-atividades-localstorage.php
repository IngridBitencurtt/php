<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestão de Atividades</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
	body {
		margin: 1px;
		background-image: linear-gradient(to right, #0F2027, #203A43, #2C5364, #2C5364, #203A43, #0F2027);
	}
</style>

<body>
	<div class="container">
		<div class="row" style="height: 25%;"></div>
		<div class="row">
			<table class="table table-light table-striped">
				<thead class="table-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col" style="width: 60%;">Atividade</th>
						<th scope="col" style="width: 25%;">Data</th>
						<th scope="col" style="width: 15%;">Operações</th>
					</tr>
				</thead>
				<tbody id="atividades">
				</tbody>
				<tfoot style="border-top: 2px solid black;">
					<tr>
						<td class="text-center" scope="row" colspan="4">
							<button class="btn add" id="add"><i class="fa-solid fa-plus" style="color: green;"></i></button>
						</td>
					</tr>
					<tfoot>
					</tfoot>
			</table>
		</div>
	</div>

	<div id="myModalCriar" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Nova Atividade</h4>
				</div>
				<div class="modal-body">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default">Atividade</span>
						</div>
						<input type="text" id="txtCriarAtividade" class="form-control" aria-label="Atividade" aria-describedby="inputGroup-sizing-default">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-criar" data-dismiss="modal">Criar</button>
				</div>
			</div>
		</div>
	</div>

	<div id="myModalEditar" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modificar Atividade</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="rowEdit">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default">Atividade</span>
						</div>
						<input type="text" id="txtModificarAtividade" class="form-control" aria-label="Atividade" aria-describedby="inputGroup-sizing-default">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-editar" data-dismiss="modal">Atualizar</button>
				</div>
			</div>
		</div>
	</div>

	<div id="myModalDeletar" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="deleteAtividade"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="rowDelete">
					<p>Confirmar exclusão?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-deletar-nao" data-dismiss="modal">Não</button>
					<button type="button" class="btn btn-primary btn-deletar-sim" data-dismiss="modal">Sim</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		var atividades = [];
		var operation;
		var input_atividade = {};
		// var list = mockData();
		// localStorage.setItem("quantidade", list.length);
		// localStorage.setItem(list);
		atividades = $.parseJSON(localStorage.getItem("atividades"));
		var quantidade = localStorage.getItem("quantidade");

		lerSessao();

		function lerSessao() {
			if (quantidade != null) {
				loadData();
			} else {
				localStorage.setItem("quantidade", 0);
			}
		}

		function mockData() {
			atividades.push({
				index: "1",
				atividade: "Atividade 1",
				date: "05/04/2022 - 08:30:00",
				status: "done"
			});
			atividades.push({
				index: "2",
				atividade: "Atividade 2",
				date: "05/04/2022 - 09:30:00",
				status: "open"
			});
			atividades.push({
				index: "3",
				atividade: "Atividade 3",
				date: "05/04/2022 - 10:30:00",
				status: "open"
			});
			atividades.push({
				index: "4",
				atividade: "Atividade 4",
				date: "05/04/2022 - 10:30:00",
				status: "done"
			});
			atividades.push({
				index: "5",
				atividade: "Atividade 5",
				date: "05/04/2022 - 10:30:00",
				status: "open"
			});
		}

		function paddingDate(item) {
			if (item.toString().length == 1) {
				return '0' + item;
			} else {
				return item;
			}
		}

		function getDate() {
			var date = new Date();
			return paddingDate(date.getDate()) + '/' +
				paddingDate((date.getMonth() + 1)) + '/' +
				paddingDate(date.getFullYear()) + ' - ' +
				paddingDate(date.getHours()) + ':' +
				paddingDate(date.getMinutes()) + ':' +
				paddingDate(date.getSeconds());
		}

		function markDone(row) {
			for (const [key, value] of Object.entries(atividades)) {
				if (value.index == row) {
					value.status = "done";
					input_atividade = value;
				}
			}

			operation = 'edit';
			operationCrud(operation, input_atividade);
			loadData();
		}

		function deleteItem(row) {
			for (const [key, value] of Object.entries(atividades)) {
				if (value.index == row) {
					input_atividade = value;
					atividades.splice(key, 1);
					break;
				}
			}
			operation = 'delete';
			operationCrud(operation, input_atividade);

			loadData();
		}

		function editItem(row, atividade) {
			var datestring = getDate();

			for (const [key, value] of Object.entries(atividades)) {
				if (value.index == row) {

					value.atividade = atividade;
					value.date = datestring;

					input_atividade = value;

					break;
				}
			}

			operation = 'edit';
			operationCrud(operation, input_atividade);

			loadData();
		}

		function addItem(atividade) {
			var datestring = getDate();
			var newRow = 1;

			if ($('#atividades tr:last')[0]) {
				newRow = parseInt($('#atividades tr:last')[0].id.replace("row", "")) + 1;
			}
			input_atividade = {
				index: newRow,
				atividade: atividade,
				date: datestring,
				status: "open"
			}

			atividades.push(input_atividade);

			operation = 'add';
			operationCrud(operation, input_atividade);
			loadData();
		}

		function loadData() {
			$('#atividades').empty();
			localStorage.clear();
			var count_atividades = 0;

			if (atividades.length > 0) {
				for (const [key, value] of Object.entries(atividades)) {
					var newRow = value.index;
					var atividade = value.atividade;
					var datestring = value.date;

					var nova_linha = '';

					localStorage.setItem(key, JSON.stringify(value));
					count_atividades = count_atividades + 1;

					if (value.status.includes("open")) {
						nova_linha =
							'<tr id="row' + newRow + '">' +
							'<th scope="row">' + newRow + '</th>' +
							'<td id="content' + newRow + '">' + atividade + '</td>' +
							'<td>' + datestring + '</td>' +
							'<td class="text-center" >' +
							'<button class="btn edit" id="edit' + newRow + '"><i class="fa-solid fa-file-pen" style="color: blue;"></i></button>' +
							'<button class="btn delete" id="delete' + newRow + '"><i class="fa fa-trash" style="color: red;"></i></button>' +
							'<button class="btn done" id="done' + newRow + '"><i class="fa-solid fa-check" style="color: green;"></i></button>' +
							'</td>' +
							'</tr>';
					} else if (value.status.includes("done")) {
						nova_linha =
							'<tr style="background-color: #FFFF99;" id="row' + newRow + '">' +
							'<th scope="row">' + newRow + '</th>' +
							'<td id="content' + newRow + '">' + atividade + '</td>' +
							'<td>' + datestring + '</td>' +
							'<td class="text-center" >' +
							'<button class="btn delete" id="delete' + newRow + '"><i class="fa fa-trash" style="color: red;"></i></button>' +
							'</td>' +
							'</tr>';
					}

					$('#atividades').append(nova_linha);
				}
			}

			localStorage.setItem("quantidade", count_atividades);
		}

		$('.btn-criar').click(function() {


			addItem($("#txtCriarAtividade").val());
			$("#txtCriarAtividade").val("");


		});

		$('.btn-editar').click(function() {
			editItem(
				$("#rowEdit").val(),
				$("#txtModificarAtividade").val()
			);

			$("#rowEdit").val("");
			$("#txtModificarAtividade").val("");
		});

		$('.btn-deletar-sim').click(function() {

			deleteItem(
				$("#rowDelete").val()
			);


			$("#rowDelete").val("");
			$("#deleteAtividade").text("");
		});

		$(document).on("click", 'button', function(element) {
			var id = element.currentTarget.id;

			if (id.includes("edit")) {

				var row = id.replace("edit", "");
				var contentId = "#content" + row;
				$("#txtModificarAtividade").val($(contentId).html());
				$("#rowEdit").val(row);
				$('#myModalEditar').modal('show');
			} else if (id.includes("delete")) {

				var row = id.replace("delete", "");
				var contentId = "#content" + row;
				$("#deleteAtividade").text($(contentId).html());
				$("#rowDelete").val(row);
				$('#myModalDeletar').modal('show');
			} else if (id.includes("add")) {

				$('#myModalCriar').modal('show');
			} else if (id.includes("done")) {
				var row = id.replace("done", "");
				markDone(row);
			}


		});

		function operationCrud(operation, input_atividade) {

			console.log(operation, input_atividade)
			$.ajax({
				method: "POST",
				url: "../backend/crud.php",
				data: {
					input_atividade,
					operation
				},
				error: function(xhr) {
					$("#resultado").html("Usuário e/ou senha inválidos.");
				}
			}, ).done(function(resposta) {
				console.log(resposta);
			});

		}
	</script>
</body>

</html>