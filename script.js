function abrirAba(abaId) {
  const abas = document.querySelectorAll('.aba');
  abas.forEach(aba => aba.classList.remove('ativo'));
  const abaSelecionada = document.getElementById(abaId);
  if (abaSelecionada) {
    abaSelecionada.classList.add('ativo');
  }
}

function gerarRelatorio() {
  document.getElementById("relatorioResultado").innerText = "Relatório gerado com sucesso!";
}
document.addEventListener('DOMContentLoaded', function () {
  const listaLivros = document.getElementById('lista-livros');
  const busca = document.getElementById('busca-livros');

  function carregarLivros() {
    fetch('listar_livros.php')
      .then(response => response.json())
      .then(data => {
        mostrarLivros(data);
        busca.addEventListener('input', () => filtrarLivros(data));
        // Dentro do forEach que cria cada item li:

        const btnEditar = document.createElement('button');
        btnEditar.textContent = 'Editar';
        btnEditar.style.marginLeft = '10px';
        btnEditar.onclick = () => carregarLivroParaEdicao(livro.id);

li.appendChild(btnEditar);

      })
      .catch(error => {
        listaLivros.innerHTML = "<li>Erro ao carregar livros.</li>";
        console.error("Erro:", error);
      });
  }

  function mostrarLivros(livros) {
    listaLivros.innerHTML = '';
    livros.forEach(livro => {
      const item = document.createElement('li');
      item.textContent = `${livro.titulo} - ${livro.autor} (${livro.status})`;
      listaLivros.appendChild(item);
    });
  }

  function filtrarLivros(livros) {
    const termo = busca.value.toLowerCase();
    const filtrados = livros.filter(livro =>
      livro.titulo.toLowerCase().includes(termo) ||
      livro.autor.toLowerCase().includes(termo)
    );
    mostrarLivros(filtrados);
  }

  carregarLivros();
});
async function carregarLivroParaEdicao(id) {
  const response = await fetch(`buscar_livro.php?id=${id}`);
  if (!response.ok) {
    alert('Erro ao buscar dados do livro');
    return;
  }
  const livro = await response.json();

  // Preencher formulário
  document.getElementById('id_livro').value = livro.id;
  document.getElementById('titulo').value = livro.titulo;
  document.getElementById('autor').value = livro.autor;
  document.getElementById('genero').value = livro.genero || '';
  document.getElementById('ano').value = livro.ano || '';
  document.getElementById('status').value = livro.status;

  // Mudar botão de submit para 'Salvar Edição'
  const btn = document.querySelector('#livros form button[type="submit"]');
  btn.textContent = 'Salvar Edição';

  // Modificar evento submit para enviar para editar_livro.php
  const form = document.querySelector('#livros form');
  form.action = 'editar_livro.php';

  // Opcional: adicionar hidden para método PUT, mas aqui é POST mesmo
}
