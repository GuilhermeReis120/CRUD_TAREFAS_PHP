const API_URL = "http://localhost:8000";

const form = document.querySelector('form');
const tarefas = [];

function adicionarTarefa(event) {
  event.preventDefault();

  const nome_tarefaInput = document.getElementById("nome_tarefa");
  const descricao_tarefaInput = document.getElementById("descricao_tarefa");

  console.log('Adicionar Tarefa:', nome_tarefaInput.value);
  console.log('Descrição Tarefa:', descricao_tarefaInput.value);

  tarefas.push({
    nome: nome_tarefaInput.value,
    descricao: descricao_tarefaInput.value
  })
  console.log('Tarefas atuais:', tarefas);
}
form.addEventListener('submit', adicionarTarefa);
