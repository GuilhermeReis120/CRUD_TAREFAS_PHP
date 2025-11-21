const API_URL = "http://localhost:8000";

const form = document.querySelector('form');

function adicionarTarefa(event) {
  event.preventDefault();

  const nome_tarefaInput = document.getElementById("nome_tarefa");
  const descricao_tarefaInput = document.getElementById("descricao_tarefa");

  console.log('Adicionar Tarefa:', nome_tarefaInput.value, descricao_tarefaInput.value);
}
  form.addEventListener('submit', adicionarTarefa);
