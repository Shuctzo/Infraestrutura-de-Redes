# Instruções para Implementação no Cisco Packet Tracer

Este guia detalha os passos para construir a infraestrutura de rede hospitalar no Cisco Packet Tracer, baseando-se no planejamento da arquitetura de rede.

## 1. Configuração da Camada de Núcleo (Core)

1.  **Adicionar Roteadores/Switches Layer 3:** No Packet Tracer, adicione dois roteadores de alta performance (ex: Cisco 4321 ou 2911) ou switches multicamadas (ex: Cisco 3560 ou 3650) para atuar como a camada de núcleo. Conecte-os redundantemente (ex: via EtherChannel ou links de fibra).
2.  **Configurar Interfaces:** Atribua endereços IP às interfaces que se conectarão à camada de distribuição. Configure protocolos de roteamento (ex: OSPF ou EIGRP) para garantir a comunicação entre as VLANs.
3.  **Configurar VLANs:** Crie todas as VLANs definidas na tabela de endereçamento IP (`arquitetura_rede.md`) nos switches core (se forem switches Layer 3) ou configure o roteador para roteamento inter-VLAN (Router-on-a-Stick ou SVI).

## 2. Configuração da Camada de Distribuição

1.  **Adicionar Switches Layer 3:** Adicione switches Layer 3 (ex: Cisco 3560 ou 3650) para cada setor principal ou andar do hospital. Conecte cada switch de distribuição aos switches core de forma redundante.
2.  **Configurar Interfaces:** Atribua endereços IP às interfaces que se conectarão à camada de acesso e configure o roteamento para as VLANs correspondentes a cada setor.
3.  **Configurar VLANs:** Crie as VLANs relevantes para os setores conectados a cada switch de distribuição.
4.  **Configurar Port-Security e ACLs:** Implemente segurança nas portas dos switches de distribuição e configure ACLs para controlar o tráfego entre as VLANs, conforme o plano de segurança.

## 3. Configuração da Camada de Acesso

1.  **Adicionar Switches Layer 2:** Adicione switches Layer 2 (ex: Cisco 2960) em cada área ou sala que necessite de conectividade. Conecte cada switch de acesso ao seu respectivo switch de distribuição.
2.  **Configurar Portas:** Configure as portas dos switches de acesso como portas de acesso (access ports) para as VLANs específicas de cada dispositivo (computadores, telefones IP, equipamentos médicos) ou como portas trunk para os Access Points.
3.  **Configurar PoE:** Habilite PoE nas portas que conectarão Access Points e telefones IP.
4.  **Configurar Port-Security:** Implemente segurança nas portas para limitar o número de MAC addresses permitidos por porta.

## 4. Configuração de Access Points (APs) Wireless

1.  **Adicionar APs:** Adicione Access Points (ex: Cisco Aironet APs) em locais estratégicos para cobrir todas as áreas do hospital. Conecte-os aos switches de acesso com PoE.
2.  **Configurar SSIDs e Segurança:** Crie múltiplos SSIDs (ex: `Hospital-Staff`, `Hospital-Guest`, `Medical-Devices`). Configure a segurança (WPA2/WPA3) e, para redes corporativas, utilize autenticação RADIUS (servidor de domínio).
3.  **VLANs para Wireless:** Associe cada SSID a uma VLAN específica para segmentar o tráfego sem fio (ex: `Hospital-Staff` na VLAN de Administração, `Hospital-Guest` na VLAN de Visitantes).

## 5. Configuração dos Servidores

1.  **Adicionar Servidores:** No Packet Tracer, adicione os servidores listados no plano (`arquitetura_rede.md`) na VLAN 200 (Datacenter).
2.  **Configurar Endereços IP:** Atribua os endereços IP estáticos, máscaras de sub-rede e gateways padrão conforme a tabela de servidores.
3.  **Configurar Serviços:**
    *   **Servidor de Domínio (AD/DNS/DHCP):** Instale e configure os serviços de Active Directory, DNS e DHCP. O DHCP deve ser configurado para fornecer endereços IP para as diferentes VLANs (usando IP Helper-Address nos roteadores/switches Layer 3).
    *   **Servidor PEP/PACS/Aplicações/Banco de Dados/Backup/E-mail/Web/Monitoramento:** Simule a instalação e configuração dos respectivos serviços. No Packet Tracer, você pode usar o serviço HTTP para simular um servidor web, e o serviço de e-mail para simular um servidor de e-mail. Para os outros, a simulação será mais conceitual, focando na conectividade.

## 6. Conectividade e Testes

1.  **Conectar Dispositivos:** Conecte todos os dispositivos (PCs, laptops, telefones IP, equipamentos médicos) aos switches de acesso.
2.  **Testar Conectividade:** Utilize o comando `ping` e `tracert` para verificar a conectividade entre os dispositivos em diferentes VLANs e com os servidores.
3.  **Testar Serviços:** Verifique se os serviços (DHCP, DNS, HTTP, e-mail) estão funcionando corretamente.
4.  **Testar Segurança:** Tente acessar recursos de VLANs não autorizadas para verificar se as ACLs estão funcionando como esperado.

## 7. Observações para o Packet Tracer

*   **Limitações:** O Packet Tracer é uma ferramenta de simulação e possui algumas limitações em relação a equipamentos reais. Nem todos os recursos avançados de segurança ou virtualização podem ser totalmente simulados.
*   **Representação:** Use ícones apropriados para representar os diferentes tipos de dispositivos (PCs, laptops, telefones IP, servidores, equipamentos médicos genéricos).
*   **Organização:** Organize o layout da rede de forma clara, utilizando caixas de texto e formas para delimitar os setores e as VLANs.

