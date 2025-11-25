const API_URL = "http://localhost:8000";
const listaTarefasUL = document.querySelector('.lista-tarefas ul');
const form = document.querySelector('form');

async function excluirTarefa(id) {
  if (!confirm('Tem certeza que deseja excluir esta tarefa?')) {
    return;
  }

  try {

    const response = await fetch(`${API_URL}/tarefas/${id}`, {
      method: 'DELETE',
    });

    const data = await response.json();

    if (response.ok) {
      console.log('Tarefa excluída com sucesso:', data.mensagem);
      await carregarTarefas(); 
    } else {
      console.error('Erro ao excluir tarefa:', data.mensagem || 'Erro desconhecido');
    }

  } catch (error) {
    console.error('Erro na comunicação com a API (DELETE):', error);
  }
}

async function alternarStatus(tarefa) {

  const novoStatus = tarefa.status === 'pendente' ? 'completa' : 'pendente';

  const tarefaAtualizada = {
    id: tarefa.id, 
    titulo: tarefa.titulo,
    descricao: tarefa.descricao,
    status: novoStatus 
  };

  try {
    const response = await fetch(`${API_URL}/tarefas/${tarefa.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(tarefaAtualizada)
    });

    const data = await response.json();

    if (response.ok) {
      console.log('Tarefa atualizada com sucesso:', data.mensagem);
      await carregarTarefas(); 
    } else {
      console.error('Erro ao atualizar tarefa:', data.mensagem || 'Erro desconhecido');
    }

  } catch (error) {
    console.error('Erro na comunicação com a API (PUT):', error);
  }
}

async function carregarTarefas() {
  listaTarefasUL.innerHTML = ''; 

  try {
    const response = await fetch(`${API_URL}/tarefas`);
    const tarefas = await response.json();

    if (tarefas && Array.isArray(tarefas)) {
      tarefas.forEach(tarefa => {
        const li = document.createElement('li');
        
        li.className = tarefa.status === 'completa' ? 'completa' : ''; 
        
        const statusButtonText = tarefa.status === 'pendente' ? 'Marcar como Completa' : 'Marcar como Pendente';

        li.innerHTML = `
          <div class="tarefa-conteudo">
            <strong>${tarefa.titulo}</strong> 
            <p>${tarefa.descricao}</p>
            <small>Status: <strong>${tarefa.status.toUpperCase()}</strong></small>
          </div>
          <div class="tarefa-acoes">
            <button class="status-btn" data-tarefa-id="${tarefa.id}">${statusButtonText}</button>
            <button class="delete-btn" data-tarefa-id="${tarefa.id}">Excluir</button>
          </div>
        `;
        
        li.querySelector('.status-btn').addEventListener('click', () => alternarStatus(tarefa));
        li.querySelector('.delete-btn').addEventListener('click', () => excluirTarefa(tarefa.id));

        listaTarefasUL.appendChild(li);
      });
    } else {
        const li = document.createElement('li');
        li.textContent = "Nenhuma tarefa cadastrada. Adicione uma nova!";
        listaTarefasUL.appendChild(li);
    }
  } catch (error) {
    console.error('Erro ao carregar tarefas:', error);
    const li = document.createElement('li');
    li.textContent = "Erro ao conectar com a API de tarefas.";
    listaTarefasUL.appendChild(li);
  }
}


async function adicionarTarefa(event) {
  event.preventDefault();

  const nome_tarefaInput = document.getElementById("nome_tarefa");
  const descricao_tarefaInput = document.getElementById("descricao_tarefa");

  const novaTarefa = {
    titulo: nome_tarefaInput.value, 
    descricao: descricao_tarefaInput.value,
    status: 'pendente' 
  };

  try {
    const response = await fetch(`${API_URL}/tarefas`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(novaTarefa)
    });

    const data = await response.json();
    
    if (response.ok) {
      console.log('Tarefa adicionada com sucesso:', data.mensagem);
      form.reset();
      await carregarTarefas(); 
    } else {
      console.error('Erro ao adicionar tarefa:', data.mensagem || 'Erro desconhecido');
    }

  } catch (error) {
    console.error('Erro na comunicação com a API:', error);
  }
}


form.addEventListener('submit', adicionarTarefa);
carregarTarefas();